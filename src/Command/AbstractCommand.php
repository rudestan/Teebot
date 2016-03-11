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

        $methodName = SendMessage::NAME;

        $args = [
            'text' => $text,
            'chat_id' => $chatId
        ];

        /*

        Todo: pass object as args

               $entity = new Message();
               $entity->setText($text);
               $entity->setChatId($chatId);

        */


        return $this->callRemoteMethod($methodName, $args, false);
    }

    protected function callRemoteMethod($methodName, $args = [], $processResponse = true)
    {
        $executor = new Executor();

        return $executor->callRemoteMethod($methodName, $args, $processResponse, $this->entity);
    }
}
