<?php

/**
 * Event and command executor class. Goes trough entities in response object and triggers corresponding
 * entity events and/or commands, either mapped in config file or via default Teebot\Bot namespace.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author  Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Command;

use Teebot\Api\Entity\AbstractEntity;
use Teebot\Api\Entity\Error;
use Teebot\Api\Entity\Message;
use Teebot\Api\Entity\MessageEntity;
use Teebot\Api\Entity\MessageEntityArray;
use Teebot\Api\Entity\Update;
use Teebot\Api\Exception\ProcessEntitiesChainException;
use Teebot\Api\Exception\ProcessEntitiesException;
use Teebot\Api\HttpClient;
use Teebot\Api\Method\AbstractMethod;
use Teebot\Api\Request;
use Teebot\Api\Response;
use Teebot\Configuration\AbstractContainer as ConfigContainer;
use Teebot\Configuration\ValueObject\EventConfig;

class Processor
{
    /** @var ConfigContainer $config */
    protected $config;

    /** @var HttpClient $httpClient */
    protected $httpClient;

    /**
     * Processor constructor.
     *
     * @param ConfigContainer $config
     * @param HttpClient      $httpClient
     */
    public function __construct(ConfigContainer $config, HttpClient $httpClient)
    {
        $this->config     = $config;
        $this->httpClient = $httpClient;
    }

    /**
     * Processes array of entities from response object, root entities must be either update entity
     * or error entity in case of error response from Telegram's API.
     *
     * @param array $entities Array of entities (Update or Error) passed either from response object or
     *                        directly to the method
     *
     * @return bool
     *
     * @throws ProcessEntitiesException
     */
    public function processEntities(array $entities)
    {
        /** @var Update $entity */
        foreach ($entities as $entity) {
            $entitiesChain = $this->getEntitiesChain($entity);

            if (empty($entitiesChain)) {
                throw new ProcessEntitiesException("Unknown entity! Skipping.");
            }

            $result = $this->processEntitiesChain($entitiesChain);

            if ($result == false) {
                throw new ProcessEntitiesException("Failed to process the entity!");
            }
        }

        return true;
    }

    /**
     * Returns entities chain generated from nested sub-entities of the passed entity
     *
     * Generated hierarchy of the events:
     *
     * - Error
     * - Update
     *   - Message
     *     - Command
     *       - <Command name>
     *     - Audio ... <Any supported entity>
     *   - Inline Query
     *   - Chosen Inline Result
     *
     * @param Update|Error $entity Update or Error entity object
     *
     * @return array
     */
    public function getEntitiesChain($entity)
    {
        if ($entity instanceof Error) {
            return [
                ['entity' => $entity],
            ];
        }
        if (!$entity instanceof Update) {
            return [];
        }

        $updateTypeEntity = $entity->getUpdateTypeEntity();

        $events = [
            ['entity' => $entity],
            ['entity' => $updateTypeEntity, 'parent' => $updateTypeEntity],
        ];

        if ($updateTypeEntity instanceof Message && $updateTypeEntity->getMessageTypeEntity()) {

            $messageTypeEntity = $updateTypeEntity->getMessageTypeEntity();

            $events[] = [
                'entity' => $messageTypeEntity,
                'parent' => $updateTypeEntity,
            ];

            if ($messageTypeEntity instanceof MessageEntityArray) {
                $entities = $messageTypeEntity->getEntities();

                foreach ($entities as $entity) {
                    $events[] = [
                        'entity' => $entity,
                        'parent' => $updateTypeEntity,
                    ];
                }
            }
        }

        return $events;
    }

    /**
     * Processes generated entities chain, if triggered event returns false stops processing
     *
     * @param array $entitiesChain Array of entities
     *
     * @throws ProcessEntitiesChainException
     *
     * @return bool
     */
    protected function processEntitiesChain(array $entitiesChain)
    {
        foreach ($entitiesChain as $entityData) {
            try {
                $parent   = isset($entityData['parent']) ? $entityData['parent'] : null;
                $continue = $this->triggerEventForEntity($entityData['entity'], $parent);

                if (!$continue) {
                    return true;
                }
            } catch (\Exception $e) {
                throw new ProcessEntitiesChainException('Process entities chain error', 0, $e);
            }
        }

        return true;
    }

    /**
     * Triggers desired event and returns boolean result from run method of the event. If run() returns
     * false the processing in main process method will be stopped and further events (if any)
     * will not be triggered otherwise process will continue until either first false returned or the very
     * last event in the flow.
     *
     * @param AbstractEntity $entity    Entity for which the corresponding event should be triggered
     * @param AbstractEntity $parent    Entity's parent if any
     *
     * @return bool
     */
    protected function triggerEventForEntity(AbstractEntity $entity, AbstractEntity $parent = null)
    {
        $eventConfiguration = $this->getEventConfiguration($entity);

        if ($eventConfiguration === null) {
            return true;
        }

        $eventClass = $eventConfiguration->getClass();

        if (class_exists($eventClass)) {
            $event = new $eventClass();

            if (!$event instanceof AbstractEntityEvent && !$event instanceof AbstractCommand) {
                return true;
            }

            /** @var AbstractCommand $eventClass */
            if ($event instanceof AbstractCommand && $entity instanceof MessageEntity && $entity->isNativeCommand()) {
                $event->setArgs($entity->getArgs());
            }

            $referencedEntity = $parent ? $parent : $entity;

            $event
                ->setProcessor($this)
                ->setParams($eventConfiguration->getParams())
                ->setEntity($referencedEntity);

            return $event->run();
        }

        return true;
    }

    /**
     * Returns event configuration item search by the data from entity
     *
     * @param AbstractEntity $entity    Entity for which the corresponding event should be triggered
     *                                  be treated as a command
     * @return null|EventConfig
     */
    protected function getEventConfiguration(AbstractEntity $entity)
    {
        $preDefinedEvents = $this->config->get('events');
        $entityEventType  = $entity->getEntityType();

        if (!is_array($preDefinedEvents)) {
            return null;
        }

        /** @var EventConfig $preDefinedEvent */
        foreach ($preDefinedEvents as $preDefinedEvent) {
            $className = null;

            if ($preDefinedEvent->getType() == Message::MESSAGE_TYPE_REGEXP_COMMAND) {
                if ($entity instanceof Message && $entity->hasBuiltinRegexpCommand($preDefinedEvent->getCommand())) {
                    $className = $preDefinedEvent->getClass();
                }
            }

            if ($preDefinedEvent->getType() == $entityEventType) {
                $className = $preDefinedEvent->getClass();

                if ($entity instanceof MessageEntity && $entity->isNativeCommand()) {
                    if (!$this->isCommandSupported($preDefinedEvent->getCommand(), $entity->getCommand())) {
                        continue;
                    }
                }
            }

            if ($className && class_exists($className)) {
                return $preDefinedEvent;
            }
        }

        return null;
    }

    /**
     * Checks whether command is defined in config and matches the current one
     *
     * @param string|null $preDefinedCommand Pre command
     * @param string      $command           Command name
     *
     * @return bool
     */
    protected function isCommandSupported($preDefinedCommand, $command)
    {
        return $preDefinedCommand !== null && strtolower($preDefinedCommand) == strtolower($command);
    }

    /**
     * Executes remote method and returns response object
     * 
     * @param AbstractMethod $method     Method instance
     * @param bool           $silentMode If set to true then the events, mapped (in config or by default)
     *                                   to the entities in the result will not be triggered
     * @param AbstractEntity $parent     Parent entity (if any)
     *
     * @return Response
     */
    public function call(AbstractMethod $method, $silentMode = false, $parent = null)
    {
        $request  = new Request($this->httpClient);
        $response = $request->exec($method, $parent);

        return $this->processResponse($response, $silentMode);
    }

    /**
     * Returns a response object and starts the entities processing (if not in silent mode). Method
     * should be used only when webhook is set.
     *
     * @param string $data       Raw json data either received from php input or passed manually
     * @param bool   $silentMode If set to true then the events, mapped (in config or by default)
     *                           to the entities in the result will not be triggered
     *
     * @return Response
     */
    public function getWebhookResponse($data, $silentMode = false)
    {
        $response = new Response($data, Update::class);

        return $this->processResponse($response, $silentMode);
    }

    /**
     * Processes entities from the response object if not in silent mode or error is received.
     *
     * @param Response $response   Response object which includes entities
     * @param bool     $silentMode If set to true then the events, mapped (in config or by default)
     *                             to the entities in the result will not be triggered
     *
     * @return Response
     */
    protected function processResponse(Response $response, $silentMode = false)
    {
        if (!empty($response->getEntities()) && ($silentMode === false || $response->isErrorReceived())) {
            $this->processEntities($response->getEntities());
        }

        return $response;
    }
}
