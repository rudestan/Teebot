<?php

/**
 * Class that represents Telegram's Bot-API "sendMessage" method.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Method;

use Teebot\Api\Entity\Message;

class SendMessage extends AbstractMethod
{
    const NAME                = 'sendMessage';

    const RETURN_ENTITY       = Message::class;

    const PARSE_MODE_MARKDOWN = 'Markdown';

    const PARSE_MODE_HTML     = 'HTML';

    protected $chat_id;

    protected $text;

    protected $parse_mode;

    protected $disable_web_page_preview;

    protected $disable_notification;

    protected $reply_to_message_id;
    
    protected $reply_markup;

    protected $supportedProperties = [
        'chat_id'                  => true,
        'text'                     => true,
        'parse_mode'               => false,
        'disable_web_page_preview' => false,
        'disable_notification'     => false,
        'reply_to_message_id'      => false,
        'reply_markup'             => false,
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
        return $this->parse_mode;
    }

    /**
     * @param mixed $parse_mode
     *
     * @return $this
     */
    public function setParseMode($parse_mode)
    {
        $this->parse_mode = $parse_mode;

        return $this;
    }

    /**
     * @return $this
     */
    public function setHTMLParseMode()
    {
        $this->parse_mode = static::PARSE_MODE_HTML;

        return $this;
    }

    /**
     * @return $this
     */
    public function setMarkdownParseMode()
    {
        $this->parse_mode = static::PARSE_MODE_MARKDOWN;

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

    /**
     * @return mixed
     */
    public function getDisableNotification()
    {
        return $this->disable_notification;
    }

    /**
     * @param mixed $disable_notification
     *
     * @return $this
     */
    public function setDisableNotification($disable_notification)
    {
        $this->disable_notification = $disable_notification;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReplyToMessageId()
    {
        return $this->reply_to_message_id;
    }

    /**
     * @param mixed $reply_to_message_id
     *
     * @return $this
     */
    public function setReplyToMessageId($reply_to_message_id)
    {
        $this->reply_to_message_id = $reply_to_message_id;

        return $this;
    }
}
