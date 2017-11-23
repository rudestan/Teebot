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

declare(strict_types=1);

namespace Teebot\Api\Command;

use Teebot\Api\{
    Response,
    Entity\EntityInterface,
    Entity\Message,
    Method\SendMessage
};

abstract class AbstractEntityEvent implements EventInterface
{
    /**
     * @var Processor $processor
     */
    protected $processor;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var EntityInterface $entity
     */
    protected $entity = null;

    /**
     * Abstract method of each entity event which will be called if certain entity presents in response
     * and it's class exists or mapped in the config.
     *
     * @return null|bool
     */
    abstract public function run();

    /**
     * Sets configuration parameters
     *
     * @param array $params
     *
     * @return EventInterface
     */
    public function setParams(array $params): EventInterface
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Returns chat id if the type of calling entity or it's parent is Message
     *
     * @return null|int
     */
    public function getChatId(): ?int
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
     * @param Processor $processor
     *
     * @return EventInterface
     */
    public function setProcessor(Processor $processor): EventInterface
    {
        $this->processor = $processor;

        return $this;
    }

    /**
     * Sets entity
     *
     * @param EntityInterface $entity Entity object
     *
     * @return EventInterface
     */
    public function setEntity(EntityInterface $entity): EventInterface
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Sends text message to current chat
     *
     * @param string $text Message text
     *
     * @return Response
     */
    protected function sendMessage(string $text): Response
    {
        return $this->reply(
            (new SendMessage())
                ->setText($text)
        );
    }

    /**
     * Replies on the message
     *
     * @param SendMessage $sendMessage Object of the SendMessage method
     *
     * @return Response
     */
    protected function reply(SendMessage $sendMessage): Response
    {
        $chatId = $this->getChatId();

        if ((int)$chatId == 0) {
            return false;
        }

        $sendMessage->setChatId($chatId);

        return $this->processor->call($sendMessage, true, $this->entity);
    }
}
