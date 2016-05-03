<?php

/**
 * Event and command executor class. Goes trough entities in response object and triggers corresponding
 * entity events and/or commands, either mapped in config file or via default Teebot\Bot namespace.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author  Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Command;

use Teebot\Entity\Command;
use Teebot\Entity\Error;
use Teebot\Entity\MessageEntity;
use Teebot\Entity\Update;
use Teebot\Exception\Notice;
use Teebot\Exception\Output;
use Teebot\Method\AbstractMethod;
use Teebot\Request;
use Teebot\Entity\AbstractEntity;
use Teebot\Entity\Message;
use Teebot\Entity\MessageEntityArray;
use Teebot\Config;
use Teebot\Response;

class Handler
{
    /** @var Handler */
    protected static $instance;

    /** @var Config $config */
    protected $config;

    /** @var Request $request */
    protected $request;

    /**
     * Returns a singletone instance of executor
     *
     * @return Handler
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Returns an instance of config class
     *
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Initialises the executor, creates request object
     *
     * @param Config $config Configuration object
     */
    public function initWithConfig(Config $config)
    {
        $this->config  = $config;
        $this->request = new Request($config);
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
     * @throws Notice
     */
    public function processEntities(array $entities)
    {
        /** @var Update $entity */
        foreach ($entities as $entity) {
            $entitiesChain = $this->getEntitiesChain($entity);

            if (empty($entitiesChain)) {
                throw new Notice("Unknown entity! Skipping.");
            }

            $result = $this->processEntitiesChain($entitiesChain);

            if ($result == false) {
                throw new Notice("Failed to process the entity!");
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
                ['entity' => $entity]
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
                'parent' => $updateTypeEntity
            ];

            if ($messageTypeEntity instanceof MessageEntityArray) {
                $entities = $messageTypeEntity->getEntities();

                foreach ($entities as $entity) {
                    $events[] = [
                        'entity' => $entity,
                        'parent' => $updateTypeEntity
                    ];
                }
            }
        }

        return $events;
    }

    /**
     * Processes generated entities chain, if triggered event returns false stops processing
     *
     * @param array $entitiesFlow Array of entities flow
     *
     * @throws Notice
     *
     * @return bool
     */
    protected function processEntitiesChain(array $entitiesFlow)
    {
        foreach ($entitiesFlow as $entityData) {

            try {
                $parent   = isset($entityData['parent']) ? $entityData['parent'] : null;
                $continue = $this->triggerEventForEntity($entityData['entity'], $parent);

                if (!$continue) {
                    return true;
                }
            } catch (\Exception $e) {
                Output::log($e);
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
        $eventClass = $this->getEventClass($entity);

        if (class_exists($eventClass)) {
            $event = new $eventClass();

            if (!$event instanceof AbstractEntityEvent && !$event instanceof AbstractCommand) {
                return true;
            }

            /** @var AbstractCommand $eventClass */
            if ($event instanceof AbstractCommand && $entity instanceof MessageEntity && $entity->isCommand()) {
                $event->setArgs($entity->getArgs());
            }

            $referencedEntity = $parent ? $parent : $entity;

            $event->setEntity($referencedEntity);

            return $event->run();
        }

        return true;
    }

    /**
     * Returns mapped event class from the configuration (if it was previously defined)
     *
     * @param AbstractEntity $entity    Entity for which the corresponding event should be triggered
     *                                  be treated as a command
     * @return null|string
     */
    protected function getEventClass(AbstractEntity $entity)
    {
        $preDefinedEvents = $this->config->getEvents();
        $entityEventType  = $entity->getEntityType();

        if (!is_array($preDefinedEvents)) {
            return null;
        }

        foreach ($preDefinedEvents as $preDefinedEvent) {

            if ($preDefinedEvent['type'] == $entityEventType) {
                $className = $preDefinedEvent['class'];

                if ($entity instanceof MessageEntity && $entity->isCommand()) {
                    if (!$this->isCommandSupported($preDefinedEvent, $entity->getCommand())) {
                        continue;
                    }
                }

                if (class_exists($className)) {
                    return $className;
                }
            }
        }

        return null;
    }

    /**
     * Checks whether command is defined in config and matches the current one
     *
     * @param array  $preDefinedEvent Pre defined event data
     * @param string $command         Command name
     *
     * @return bool
     */
    protected function isCommandSupported($preDefinedEvent, $command)
    {
        return isset($preDefinedEvent['command']) && strtolower($preDefinedEvent['command']) == strtolower($command);
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
    public function callRemoteMethod(AbstractMethod $method, $silentMode = false, $parent = null)
    {
        /** @var Response $response */
        $response = $this->request->exec($method, $parent);

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
