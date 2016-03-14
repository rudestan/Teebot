<?php

namespace Teebot\Command;

use Teebot\Method\SendMessage;
use Teebot\Entity\Message;
use Teebot\Entity\AbstractEntity;

abstract class AbstractCommand
{
    protected $args = [];

    /** @var AbstractEntity $entity */
    protected $entity = null;

    abstract public function run();

    public function __construct($args = [])
    {
        $this->args = $args;
    }

    public function getChatId()
    {
        if ($this->entity instanceof Message) {
            return $this->entity->getChatId();
        }

        $parent = $this->entity->getParent();

        if ($parent instanceof Message) {
            return $parent->getChatId();
        }

        return null;
    }

    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    protected function sendMessage($text)
    {
        $chatId = $this->getChatId();

        if (!$chatId) {
            return false;
        }

        $args = [
            'text'    => $text,
            'chat_id' => $chatId
        ];

        $method = new SendMessage($args);

        return $this->callRemoteMethod($method, false);
    }

    protected function callRemoteMethod($method, $processResponse = true)
    {
        $executor = Executor::getInstance();

        return $executor->callRemoteMethod($method, $processResponse, $this->entity);
    }
}
