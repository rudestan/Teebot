<?php

namespace Teebot\Command;

use Teebot\Entity\Command;
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

    const TYPE_COMMAND      = 'command';

    const TYPE_ENTITY_EVENT = 'entity_event';

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

    public function initWithConfig(Config $config)
    {
        $this->config  = $config;
        $this->request = new Request($config);
    }

    public function processEntities(array $entities)
    {
        try {
            /** @var Update $entity */
            foreach ($entities as $entity) {
                $this->executeEntityWorkflow($entity);
            }
        } catch (Notice $e) {
            Output::log($e);
        }
    }

    // ------- processing

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
     * @author Stanislav Drozdov <stanislav.drozdov@westwing.de>
     *
     * @param $entity
     *
     * @throws Notice
     *
     * @return bool
     */
    protected function executeEntityWorkflow($entity)
    {
        if (!$entity instanceof Update) {
            throw new Notice("Unknown entity! Skipping.");
        }

        // try to execute EntityEvent Update

        if (!$this->handleEntity(self::TYPE_ENTITY_EVENT, $entity)) {
            return true;
        }

        echo "No main Update entity event found! Continue!\n";


        // try to execute events related to Update entity if any
        $entity = $entity->getUpdateTypeEntity();

        if (!$this->handleEntity(self::TYPE_ENTITY_EVENT, $entity)) {
            return true;
        }

        echo "No main Message/InlineQuery etc. entity event found! Continue!\n";

        // if it is actually message then try to get in
        if ($entity instanceof Message) {

            $subEntity = $entity->getMessageTypeEntity();

            // if it is an Event
            if ($subEntity && $subEntity instanceof AbstractEntity && !$subEntity instanceof Command) {
                if (!$this->handleEntity(self::TYPE_ENTITY_EVENT, $subEntity)) {
                    return true;
                }
            }

            echo "No Message build in entity event found! Continue!\n";

            if ($subEntity instanceof Command) {
                echo "Yes it is a command!\n";

                if (!$this->handleEntity(self::TYPE_COMMAND, $subEntity, $entity)) {
                    return true;
                }
            }
        }

        return true;
    }

    /**
     * Returns whether the workflow should continue or not
     *
     * @author Stanislav Drozdov <stanislav.drozdov@westwing.de>
     * @param $entity
     *
     * @return bool
     */
    protected function handleEntity($type = self::TYPE_ENTITY_EVENT, $entity, $parentEntity = null)
    {
        try {
            $result = $type == self::TYPE_COMMAND ? $this->runCommand($entity, $parentEntity)
                : $this->triggerEvent($entity, $parentEntity);

            if ($result == true) {
                return true;
            }
        } catch (\Exception $e) {
            Output::log($e);
        }

        return false;
    }

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

    protected function getEntityClass($type)
    {
        $nameSpace = $this->config->getEntityEventNamespace(); // @TODO: fix if namespace is not set

        return $nameSpace . "\\" . $type;
    }

    protected function runCommand(Command $entity, $parent = null)
    {
        $className = $this->getCommandClass($entity->getName());

        if (class_exists($className)) {
            /** @var AbstractCommand $instance */
            $instance = new $className($entity->getArgs());
            $instance->setEntity($parent);

            return $instance->run();
        }

        return null;
    }

    /**
     * Executes the event and returns should stop or continue workflow
     *
     * @author Stanislav Drozdov <stanislav.drozdov@westwing.de>
     * @param AbstractEntity $entity
     *
     * @return bool
     */
    protected function triggerEvent(AbstractEntity $entity, $parent = null)
    {
        $type      = $entity->getEntityType();
        $className = $this->getEntityClass($type);

        if (class_exists($className)) {

            /** @var AbstractEntityEvent $instance */
            $instance = new $className();

            if ($instance instanceof AbstractEntityEvent) {
                $instance->setEntity($parent);

                return $instance->run();
            }
        }

        return true;
    }

    // ---------------- eo processing

    public function callRemoteMethod(AbstractMethod $method, $silentMode = false, $parent = null)
    {
        /** @var Response $response */
        $response = $this->request->exec($method, $parent);

        return $this->processResponse($response, $silentMode);
    }

    public function runWebhookResponse($data, $silentMode = false)
    {
        $response = new Response($data, Message::class);

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
