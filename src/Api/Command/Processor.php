<?php

/**
 * Event and command executor class. Goes trough entities in response object and triggers corresponding
 * entity events and/or commands, either mapped in config file or via default Teebot\Bot namespace.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author  Stanislav Drozdov <rudestan@gmail.com>
 */

declare(strict_types=1);

namespace Teebot\Api\Command;

use Teebot\Api\Entity\{
    EntityInterface,
    Error,
    Message,
    MessageEntity,
    MessageEntityArray,
    Update
};
use Teebot\Api\Method\MethodInterface;
use Teebot\Api\Exception\{
    ProcessEntitiesChainException,
    ProcessEntitiesException
};
use Teebot\Api\{
    Command\ValueObject\ChainItem, HttpClient, Request, Response
};
use Teebot\Configuration\{
    AbstractContainer as ConfigContainer,
    ContainerInterface,
    ValueObject\EventConfig
};

class Processor
{
    /**
     * @var ConfigContainer $config
     */
    protected $config;

    /**
     * @var HttpClient $httpClient
     */
    protected $httpClient;

    /**
     * @param ContainerInterface $config
     * @param HttpClient      $httpClient
     */
    public function __construct(ContainerInterface $config, HttpClient $httpClient)
    {
        $this->config     = $config;
        $this->httpClient = $httpClient;
    }

    /**
     * Returns configuration container
     *
     * @return ContainerInterface
     */
    public function getConfig(): ContainerInterface
    {
        return $this->config;
    }

    /**
     * Processes array of entities from response object, root entities must be either update entity
     * or error entity in case of error response from Telegram's API.
     *
     * @param array $entities Array of entities (Update or Error) passed either from response object or
     *                        directly to the method
     *
     * @throws ProcessEntitiesException
     */
    public function processEntities(array $entities)
    {
        /** @var Update $entity */
        foreach ($entities as $entity) {
            $entitiesChain = $this->getEntitiesChain($entity);

            if (empty($entitiesChain)) {
                throw new ProcessEntitiesException("Entities chain is empty! There must be an unknown entity passed!");
            }

            $this->processEntitiesChain($entitiesChain);
        }
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
     * @param EntityInterface $entity Update or Error entity object
     *
     * @return array
     */
    public function getEntitiesChain(EntityInterface $entity): array
    {
        if ($entity instanceof Error) {
            return [
                new ChainItem($entity),
            ];
        }
        if (!$entity instanceof Update) {
            return [];
        }

        $updateTypeEntity = $entity->getUpdateTypeEntity();

        $events = [
            new ChainItem($entity),
            new ChainItem($updateTypeEntity, $updateTypeEntity),
        ];

        if ($updateTypeEntity instanceof Message && $updateTypeEntity->getMessageTypeEntity()) {

            $messageTypeEntity = $updateTypeEntity->getMessageTypeEntity();

            $events[] = new ChainItem($messageTypeEntity, $updateTypeEntity);

            if ($messageTypeEntity instanceof MessageEntityArray) {
                $entities = $messageTypeEntity->getEntities();

                foreach ($entities as $entity) {
                    $events[] = new ChainItem($entity, $updateTypeEntity);
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
     */
    protected function processEntitiesChain(array $entitiesChain)
    {
        /** @var ChainItem $chainItem */
        foreach ($entitiesChain as $chainItem) {
            try {
                $continue = $this->triggerEventForEntity($chainItem);

                if (!$continue) {
                    return;
                }
            } catch (\Exception $e) {
                throw new ProcessEntitiesChainException('Processing of the entities chain error', 0, $e);
            }
        }
    }

    /**
     * Triggers desired event and returns boolean result from run method of the event. If run() returns
     * false the processing in main process method will be stopped and further events (if any)
     * will not be triggered otherwise process will continue until either first false returned or the very
     * last event in the flow.
     *
     * @param ChainItem $chainItem
     *
     * @return bool
     */
    protected function triggerEventForEntity(ChainItem $chainItem): bool
    {
        $entity             = $chainItem->getEntity();
        $eventConfiguration = $this->getEventConfiguration($entity);

        if ($eventConfiguration === null) {
            return true;
        }

        $eventClass = $eventConfiguration->getClass();

        if (class_exists($eventClass)) {
            $event = new $eventClass();

            if (!$event instanceof EventInterface && !$event instanceof CommandInterface) {
                return true;
            }

            /** @var AbstractCommand $eventClass */
            if ($event instanceof CommandInterface && $entity instanceof MessageEntity && $entity->isNativeCommand()) {
                $event->setArgs($entity->getArgs());
            }

            $referencedEntity = $chainItem->getParent() ? $chainItem->getParent() : $entity;

            $event
                ->setProcessor($this)
                ->setParams($eventConfiguration->getParams())
                ->setEntity($referencedEntity);

            return (bool) $event->run();
        }

        return true;
    }

    /**
     * Returns event configuration item search by the data from entity
     *
     * @param EntityInterface $entity   Entity for which the corresponding event should be triggered
     *                                  be treated as a command
     *
     * @return null|EventConfig
     */
    protected function getEventConfiguration(EntityInterface $entity): ?EventConfig
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
    protected function isCommandSupported(?string $preDefinedCommand, string $command): bool
    {
        return $preDefinedCommand !== null && strtolower($preDefinedCommand) == strtolower($command);
    }

    /**
     * Executes remote method and returns response object
     *
     * @param MethodInterface $method     Method instance
     * @param bool            $silentMode If set to true then the events, mapped (in config or by default)
     *                                    to the entities in the result will not be triggered
     * @param EntityInterface $parent     Parent entity (if any)
     *
     * @return Response
     */
    public function call(MethodInterface $method, $silentMode = false, EntityInterface $parent = null)
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
