<?php

namespace Teebot\Command;

use Teebot\Entity\Command;
use Teebot\Entity\Error;
use Teebot\Entity\Update;
use Teebot\Exception\Notice;
use Teebot\Exception\Output;
use Teebot\Method\AbstractMethod;
use Teebot\Request;
use Teebot\Entity\AbstractEntity;
use Teebot\Entity\Message;
use Teebot\Config;
use Teebot\Response;

class Executor
{
    const COMMAND_UNKNOWN_CLASSNAME = 'Unknown';

    /** @var Executor */
    protected static $instance;

    /** @var Config $config */
    protected $config;

    /** @var Request $request */
    protected $request;

    /**
     * @return Executor
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Does initialisation steps
     *
     * @param Config $config Configuration object
     */
    public function initWithConfig(Config $config)
    {
        $this->config  = $config;
        $this->request = new Request($config);
    }

    /**
     * Processes array of entities
     *
     * @param array $entities Array of entities passed either from response object or
     * directly to the method
     */
    public function processEntities(array $entities)
    {
        try {
            /** @var Update $entity */
            foreach ($entities as $entity) {
                $entitiesFlow = $this->getNestedEntitiesFlow($entity);

                if (empty($entitiesFlow)) {
                    throw new Notice("Unknown entity! Skipping.");
                }

                $this->processNestedEntitiesFlow($entitiesFlow);
            }
        } catch (Notice $e) {
            Output::log($e);
        }
    }

    /**
     * Returns nested entities flow array for passed entity
     *
     * @param Update $entity Update entity object
     *
     * @return array
     */
    protected function getNestedEntitiesFlow($entity)
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
            $events[] = [
                'entity' => $updateTypeEntity->getMessageTypeEntity(),
                'parent' => $updateTypeEntity
            ];
        }

        return $events;
    }

    /**
     * Workflow hierarchy:
     *
     *
     * 1. Entity events:
     *
     * 1. Update
     * 1.1 - Message
     * 1.2 - Inline Query
     * 1.3 - Chosen Inline Result
     *
     * 2. Message
     * 1.1 - Message
     * 1.1.1 - if it is a command run command
     * ...
     * 1.1.N - any number of command
     * 1.2 - Audio
     * ...
     * 1.N - Sticker
     * 3. Inline Query
     * 4. Chosen result
     *
     * @param array $eventFlow
     *
     * @throws Notice
     *
     * @return bool
     */
    protected function processNestedEntitiesFlow(array $entitiesFlow)
    {
        foreach ($entitiesFlow as $entityData) {

            try {
                $continue = $this->triggerEvent($entityData['entity'], $entityData['parent'] ?? null);

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
     * Returns full name (including namespace) of the command class to be able
     * to instantiate it via autoloader.
     *
     * @param string $command
     *
     * @return string
     */
    protected function getCommandClass($command)
    {
        $parts = explode(Command::COMMAND_PARTS_DELIMITER, $command);
        array_walk($parts, function (&$part) {
            $part = ucfirst($part);
        });

        $name = implode('', $parts);

        $nameSpace = $this->config->getCommandNamespace();
        $className = $nameSpace . "\\" . $name;

        if (!class_exists($className) && $this->config->getCatchUnknownCommand() == true) {
            $className = $nameSpace . "\\" . static::COMMAND_UNKNOWN_CLASSNAME;

            if (!class_exists($className)) {
                $className = __NAMESPACE__ . "\\" . static::COMMAND_UNKNOWN_CLASSNAME;
            }
        }

        return $className;
    }

    /**
     * Returns full name (including namespace) of the entity event class to be able
     * to instantiate it via autoloader.
     *
     * @param string $type
     *
     * @return string
     */
    protected function getEntityEventClass($type)
    {
        $nameSpace = $this->config->getEntityEventNamespace(); // @TODO: fix if namespace is not set

        return $nameSpace . "\\" . $type;
    }


    /**
     * Executes the event and returns should stop or continue workflow
     *
     * @param AbstractEntity $entity
     * @param AbstractEntity $parent
     *
     * @return bool
     */
    protected function triggerEvent(AbstractEntity $entity, AbstractEntity $parent = null)
    {
        $instance = $this->getEvent($entity);

        if ($instance instanceof AbstractEntityEvent || $instance instanceof AbstractCommand) {
            $instance->setEntity($parent ?? $entity);

            return $instance->run();
        }

        return true;
    }

    protected function getEvent($entity)
    {
        if ($this->config->getEvents()) {
            return $this->getPreDefinedEventObject($entity);
        }

        return $this->getDefaultEventObject($entity);
    }

    protected function getPreDefinedEventObject(AbstractEntity $entity)
    {
        $preDefinedEvents = $this->config->getEvents();
        $entityEventType  = $entity->getEntityType();

        foreach ($preDefinedEvents as $preDefinedEvent) {
            if ($preDefinedEvent['type'] == $entityEventType) {
                $className = $preDefinedEvent['class'];
                $args      = [];

                if ($entity instanceof Command) {
                    $args    = $entity->getArgs();
                    $command = $entity->getName();

                    if (isset($preDefinedEvent['command']) && $preDefinedEvent['command'] != $command) {
                        continue;
                    }
                }

                if (class_exists($className)) {
                    return new $className($args);
                }
            }
        }

        return null;
    }

    protected function getDefaultEventObject($entity)
    {
        $args      = [];
        $className = null;

        if ($entity instanceof Command) {
            $args      = $entity->getArgs();
            $className = $this->getCommandClass($entity->getName());
        } elseif ($entity instanceof AbstractEntity) {
            $className = $this->getEntityEventClass($entity->getEntityType());
        }

        if ($className && class_exists($className)) {
            /** @var AbstractCommand|AbstractEntity $instance */
            return new $className($args);
        }

        return null;
    }

    public function callRemoteMethod(AbstractMethod $method, $silentMode = false, $parent = null)
    {
        /** @var Response $response */
        $response = $this->request->exec($method, $parent);

        return $this->processResponse($response, $silentMode);
    }

    public function getWebhookResponse($data, $silentMode = false)
    {
        $response = new Response($data, Update::class);

        return $this->processResponse($response, $silentMode);
    }

    protected function processResponse(Response $response, $silentMode = false)
    {
        if (!empty($response->getEntities()) && ($silentMode == false || $response->isErrorReceived())) {
            $this->processEntities($response->getEntities());
        }

        return $response;
    }
}
