<?php

/**
 * Class that represents Telegram's Bot-API "editMessageText" method.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Method\Update;

use Teebot\Entity\Message;
use Teebot\Method\AbstractMethod;

class EditMessageText extends AbstractMethod
{
    const NAME          = 'editMessageText';

    const RETURN_ENTITY = Message::class;

    protected $chat_id;

    protected $message_id;

    protected $inline_message_id;

    protected $text;

    protected $parseMode;

    protected $disable_web_page_preview;

    protected $supportedProperties = [
        'chat_id'                  => false,
        'message_id'               => false,
        'inline_message_id'        => false,
        'text'                     => true,
        'parse_mode'               => false,
        'disable_web_page_preview' => false,
        'reply_markup'             => false
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

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParseMode()
    {
        return $this->parseMode;
    }

    /**
     * @param mixed $parseMode
     *
     * @return $this
     */
    public function setParseMode($parseMode)
    {
        $this->parseMode = $parseMode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDisableWebPagePreview()
    {
        return $this->disable_web_page_preview;
    }

    /**
     * @param mixed $disable_web_page_preview
     *
     * @return $this
     */
    public function setDisableWebPagePreview($disable_web_page_preview)
    {
        $this->disable_web_page_preview = $disable_web_page_preview;

        return $this;
    }
}