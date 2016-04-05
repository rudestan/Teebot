<?php

/**
 * Abstract entity event class is base class for creating the events for received in response entities. It
 * includes methods to be able to quickly get a chat id and reply on message, get parent entity which
 * triggered this entity event.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author  Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Command;

use Teebot\Method\SendMessage;
use Teebot\Entity\Message;
use Teebot\Entity\AbstractEntity;

abstract class AbstractEntityEvent
{
    /** @var AbstractEntity $entity */
    protected $entity = null;

    /**
     * Abstract method of each entity event which will be called if certain entity presents in response
     * and it's class exists or mapped in the config. 
     * 
     * @return null|bool
     */
    abstract public function run();

    /**
     * Returns chat id if the type of calling entity or it's parent is Message
     *
     * @return null|int
     */
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

    /**
     * Sets entity
     *
     * @param AbstractEntity $entity Entity object
     */
    public function setEntity(AbstractEntity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * Sends text message to current chat
     *
     * @param string $text Message text
     *
     * @return bool|\Teebot\Response
     */
    protected function sendMessage($text)
    {
        $chatId = $this->getChatId();

        if ($chatId) {
            return false;
        }

        return (new SendMessage())
            ->setParent($this->entity)
            ->setChatId($chatId)
            ->setText($text)
            ->trigger();
    }

    /**
     * Replies on the message
     *
     * @param SendMessage $sendMessage Object of the SendMessage method
     *
     * @return bool|\Teebot\Response
     */
    protected function reply(SendMessage $sendMessage) {
        $chatId = $this->getChatId();

        if (!$chatId) {
            return false;
        }

        return $sendMessage
            ->setParent($this->entity)
            ->setChatId($chatId)
            ->trigger();
    }
}
