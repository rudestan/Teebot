<?php

/**
 * Class that represents Telegram's Bot-API "sendDocument" method.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Method;

use Teebot\Api\Entity\Message;
use Teebot\Api\Traits\File;
use Teebot\Api\Entity\InputFile;

class SendDocument extends AbstractMethod
{
    use File;

    const NAME          = 'sendDocument';

    const RETURN_ENTITY = Message::class;

    protected $chat_id;

    protected $document;

    protected $caption;

    protected $disable_notification;

    protected $reply_to_message_id;

    protected $reply_markup;

    protected $supportedProperties = [
        'chat_id'  => true,
        'document' => true,
        'caption'  => false,
        'disable_notification' => false,
        'reply_to_message_id' => false,
        'reply_markup' => false
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
     * @return \CURLFile|string
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param string $document
     *
     * @return $this
     */
    public function setDocument($document)
    {
        $this->document = $this->initInputFile($document);

        return $this;
    }
}
