<?php

namespace Teebot\Entity\Inline;

use Teebot\Entity\AbstractEntity;

class InlineQueryResultPhoto extends AbstractEntity
{
    const ENTITY_TYPE = 'InlineQueryResultPhoto';

    const RESULT_TYPE = 'photo';

    protected $id;

    protected $photo_url;

    protected $photo_width;

    protected $photo_height;

    protected $thumb_url;

    protected $title;

    protected $description;

    protected $caption;

    protected $message_text;

    protected $parse_mode;

    protected $disable_web_page_preview;

    protected $supportedProperties = [
        'type'      => true,
        'id'        => true,
        'photo_url' => true,
        'thumb_url' => true
    ];

    /**
     * @return mixed
     */
    public function getPhotoUrl()
    {
        return (string) $this->photo_url;
    }

    /**
     * @param mixed $photo_url
     */
    public function setPhotoUrl($photo_url)
    {
        $this->photo_url = $photo_url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhotoWidth()
    {
        return (int) $this->photo_width;
    }

    /**
     * @param mixed $photo_width
     */
    public function setPhotoWidth($photo_width)
    {
        $this->photo_width = $photo_width;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhotoHeight()
    {
        return (int) $this->photo_height;
    }

    /**
     * @param mixed $photo_height
     */
    public function setPhotoHeight($photo_height)
    {
        $this->photo_height = $photo_height;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getThumbUrl()
    {
        return (string) $this->thumb_url;
    }

    /**
     * @param mixed $thumb_url
     */
    public function setThumbUrl($thumb_url)
    {
        $this->thumb_url = $thumb_url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
     * @param mixed $description
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
    public function getParseMode()
    {
        return $this->parse_mode;
    }

    /**
     * @param mixed $parse_mode
     */
    public function setParseMode($parse_mode)
    {
        $this->parse_mode = $parse_mode;

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
     * @param mixed $message_text
     */
    public function setMessageText($message_text)
    {
        $this->message_text = $message_text;

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
     */
    public function setDisableWebPagePreview($disable_web_page_preview)
    {
        $this->disable_web_page_preview = $disable_web_page_preview;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return static::RESULT_TYPE;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return (string) $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
