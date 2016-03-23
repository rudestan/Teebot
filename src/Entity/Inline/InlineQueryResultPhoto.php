<?php

namespace Teebot\Entity\Inline;

class InlineQueryResultPhoto extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultPhoto';

    const RESULT_TYPE = 'photo';

    protected $photo_url;

    protected $photo_width;

    protected $photo_height;

    protected $description;

    protected $caption;

    protected $message_text;

    protected $supportedProperties = [
        'type'                     => true,
        'id'                       => true,
        'photo_url'                => true,
        'photo_width'              => false,
        'photo_height'             => false,
        'thumb_url'                => true,
        'title'                    => false,
        'description'              => false,
        'caption'                  => false,
        'message_text'             => false,
        'parse_mode'               => false,
        'disable_web_page_preview' => false
    ];

    /**
     * @return string
     */
    public function getPhotoUrl()
    {
        return (string) $this->photo_url;
    }

    /**
     * @param string $photo_url
     *
     * @return $this
     */
    public function setPhotoUrl($photo_url)
    {
        $this->photo_url = $photo_url;

        return $this;
    }

    /**
     * @return int
     */
    public function getPhotoWidth()
    {
        return (int) $this->photo_width;
    }

    /**
     * @param int $photo_width
     *
     * @return $this
     */
    public function setPhotoWidth($photo_width)
    {
        $this->photo_width = $photo_width;

        return $this;
    }

    /**
     * @return int
     */
    public function getPhotoHeight()
    {
        return (int) $this->photo_height;
    }

    /**
     * @param int $photo_height
     *
     * @return $this
     */
    public function setPhotoHeight($photo_height)
    {
        $this->photo_height = $photo_height;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * @param string $caption
     *
     * @return $this
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessageText()
    {
        return $this->message_text;
    }

    /**
     * @param string $message_text
     *
     * @return $this
     */
    public function setMessageText($message_text)
    {
        $this->message_text = $message_text;

        return $this;
    }
}
