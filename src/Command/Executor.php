<?php

namespace Teebot\Command;

use Teebot\Exception\Fatal;
use Teebot\Method\AbstractMethod;
use Teebot\Request;
use Teebot\Entity\AbstractEntity;
use Teebot\Entity\Message;
use Teebot\Config;
use Teebot\Response;

class Executor
{
    const COMMAND_PREFIX = '/';

    const COMMAND_ARGS_SEPARATOR = ' ';

    const COMMAND_PARTS_DELIMITER = '_';

    const COMMAND_UNKNOWN_CLASSNAME = 'Unknown';

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
        /** @var Message $entity */
        foreach ($entities as $entity) {
            $command = null;

            if ($entity instanceof Message) {
                $command = $this->getCommand($entity->getText());
            }

            if (strlen($command) > 0) {
                $args = $this->getArgString($command, $entity->getText());

                $this->executeCommand($command, $args, $entity);
            } else {
                $this->executeEvent($entity);
            }
        }
    }

    protected function getCommand($text)
    {
        $command = null;

        if (!is_string($text) || !strlen($text)) {
            return $command;
        }

        if (strpos($text, static::COMMAND_ARGS_SEPARATOR) !== false) {
            $parts = explode(static::COMMAND_ARGS_SEPARATOR, $text);
            $text = $parts[0];
        }

        if ($text[0] == static::COMMAND_PREFIX) {
            $command = trim(substr($text, 1, strlen($text) - 1));
        }

        return $command;
    }

    protected function getArgString($command, $text)
    {
        $length = strlen(static::COMMAND_PREFIX . $command);

        $argString = trim(substr($text, $length));

        if (strlen($argString)) {
            return $argString;
        }

        return null;
    }

    protected function getCommandClass($command)
    {
        $parts = explode(static::COMMAND_PARTS_DELIMITER, $command);
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
        $nameSpace = $this->config->getEntityEventNamespace(); // fix if namespace is not set

        return $nameSpace . "\\" . $type;
    }

    protected function executeCommand($command, $args, $entity)
    {
        $className = $this->getCommandClass($command);

        if (class_exists($className)) {
            /** @var AbstractCommand $instance */
            $instance = new $className($args);
            $instance->setEntity($entity);

            return $instance->run();
        }

        return null;
    }

    protected function executeEvent(AbstractEntity $entity)
    {
        $type      = $entity->getEntityType();
        $className = $this->getEntityClass($type);

        if (class_exists($className)) {

            /** @var AbstractCommand $instance */
            $instance = new $className();

            if ($instance instanceof AbstractCommand) {
                $instance->setEntity($entity);

                return $instance->run();
            }
        }

        return null;
    }

    public function callRemoteMethod(AbstractMethod $method, $silentMode = false, $parent = null)
    {
        /** @var Response $response */

        $response = $this->request->exec($method, $parent);

        if ($response instanceof Response && (!$silentMode || $response->isErrorReceived())) {
            $this->processEntities($response->getEntities());
        }

        return $response;
    }
}
