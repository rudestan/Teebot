<?php

namespace Teebot\Command;

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

        $nameSpace = Config::getInstance()->getCommandNamespace();
        $className = $nameSpace . "\\" . $name;

        if (!class_exists($className) && Config::getInstance()->getCatchUnknownCommand() == true) {
            $className = $nameSpace . "\\" . static::COMMAND_UNKNOWN_CLASSNAME;

            if (!class_exists($className)) {
                $className = __NAMESPACE__ . "\\" . static::COMMAND_UNKNOWN_CLASSNAME;
            }
        }

        return $className;
    }

    protected function getEntityClass($type)
    {
        $nameSpace = Config::getInstance()->getEntityEventNamespace();

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
        $type = $entity->getEntityType();

        $className = $this->getEntityClass($type);

        if (class_exists($className)) {
            /** @var AbstractCommand $instance */
            $instance = new $className();
            $instance->setEntity($entity);

            return $instance->run();
        }

        return null;
    }

    public function callRemoteMethod($method, $args = [], $processResponse = true, $parent = null)
    {
        $request = Request::getInstance();

        /** @var Response $response */
        $response = $request->exec($method, $args, $parent);

        if ($response instanceof Response && ($processResponse || $response->isErrorReceived())) {
            $this->processEntities($response->getEntities());
        }

        return $response;
    }
}
