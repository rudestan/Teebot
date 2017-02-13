<?php

/**
 * Class that represents Telegram's Bot-API "editMessageReplyMarkup" method.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author  Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Method\Update;

use Teebot\Api\Entity\Message;
use Teebot\Api\Method\AbstractMethod;

class EditMessageReplyMarkup extends AbstractMethod
{
    const NAME          = 'editMessageReplyMarkup';

    const RETURN_ENTITY = Message::class;

    protected $chat_id;

    protected $message_id;

    protected $inline_message_id;

    protected $supportedProperties = [
        'chat_id'           => false,
        'message_id'        => false,
        'inline_message_id' => false,
        'reply_markup'      => false
    ];

    /**
     * @return mixed
     */
    public function getChatId()
    {
        return $this->chat_id;
    }

    /**
     * @param mixed $chat_id
     *
     * @return $this
     */
    public function setChatId($chat_id)
    {
        $this->chat_id = $chat_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessageId()
    {
        return $this->message_id;
    }

    /**
     * @param mixed $message_id
     *
     * @return $this
     */
    public function setMessageId($message_id)
    {
        $this->message_id = $message_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInlineMessageId()
    {
        return $this->inline_message_id;
    }

    /**
     * @param mixed $inline_message_id
     *
     * @return $this
     */
    public function setInlineMessageId($inline_message_id)
    {
        $this->inline_message_id = $inline_message_id;

        return $this;
    }
}
