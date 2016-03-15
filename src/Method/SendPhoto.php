<?php

namespace Teebot\Method;

use Teebot\Entity\Message;
use Teebot\Traits\File;
use Teebot\Entity\InputFile;

class SendPhoto extends AbstractMethod
{
    use File;

    const NAME          = 'sendPhoto';

    const RETURN_ENTITY = Message::class;

    protected $chat_id;

    protected $photo;

    protected $caption;

    protected $disable_notification;

    protected $reply_to_message_id;

    protected $reply_markup;

    protected $supportedProperties = [
        'chat_id'              => true,
        'photo'                => true,
        'caption'              => false,
        'disable_notification' => false,
        'reply_to_message_id'  => false,
        'reply_markup'         => false
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
     */
    public function setChatId($chat_id)
    {
        $this->chat_id = $chat_id;
    }

    /**
     * @return \CURLFile
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     *
     * @return $this
     */
    public function setPhoto($photo)
    {
        $inputFile   = new InputFile($photo);
        $this->photo = $inputFile->getFileForUpload();

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param mixed $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

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
     */
    public function setReplyToMessageId($reply_to_message_id)
    {
        $this->reply_to_message_id = $reply_to_message_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReplyMarkup()
    {
        return $this->reply_markup;
    }

    /**
     * @return array
     */
    public function getSupportedProperties()
    {
        return $this->supportedProperties;
    }

    /**
     * @param array $supportedProperties
     */
    public function setSupportedProperties($supportedProperties)
    {
        $this->supportedProperties = $supportedProperties;

        return $this;
    }
}
