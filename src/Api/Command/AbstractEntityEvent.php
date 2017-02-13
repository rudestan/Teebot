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

namespace Teebot\Api\Command;

use Teebot\Api\Method\SendMessage;
use Teebot\Api\Entity\Message;
use Teebot\Api\Entity\AbstractEntity;
use Teebot\Api\Method\AbstractMethod;

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
        return $this->reply(
            (new SendMessage())
                ->setText($text)
        );
    }

    /**
     * Replies on the message
     *
     * @param AbstractMethod $sendMessage Object of the SendMessage method
     *
     * @return bool|\Teebot\Response
     */
    protected function reply(AbstractMethod $sendMessage) {
        $chatId = $this->getChatId();

        if ((int) $chatId == 0) {
            return false;
        }

        return $sendMessage
            ->setParent($this->entity)
            ->setChatId($chatId)
            ->trigger();
    }
}
