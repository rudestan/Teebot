<?php

namespace Teebot\Api\Entity\Inline\Result;

class InlineQueryResultPhoto extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultPhoto';

    const RESULT_TYPE = 'photo';

    protected $photo_url;

    protected $photo_width;

    protected $photo_height;

    protected $description;

    protected $caption;

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
        'reply_markup'             => false,
        'input_message_content'    => true,
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
}
