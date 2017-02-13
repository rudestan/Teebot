<?php

namespace Teebot\Api\Entity\Inline\Result;

class InlineQueryResultArticle extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultArticle';

    const RESULT_TYPE = 'article';

    protected $message_text;

    protected $url;

    protected $hide_url;

    protected $description;

    protected $thumb_width;

    protected $thumb_height;

    protected $supportedProperties = [
        'type'                     => true,
        'id'                       => true,
        'title'                    => true,
        'input_message_content'    => true,
        'reply_markup'             => false,
        'url'                      => false,
        'hide_url'                 => false,
        'description'              => false,
        'thumb_url'                => false,
        'thumb_width'              => false,
        'thumb_height'             => false,
    ];

    /**
     * @return mixed
     */
    public function getMessageText()
    {
        return $this->message_text;
    }

    /**
     * @param mixed $message_text
     *
     * @return $this
     */
    public function setMessageText($message_text)
    {
        $this->message_text = $message_text;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHideUrl()
    {
        return $this->hide_url;
    }

    /**
     * @param mixed $hide_url
     *
     * @return $this
     */
    public function setHideUrl($hide_url)
    {
        $this->hide_url = $hide_url;

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
    public function getThumbWidth()
    {
        return $this->thumb_width;
    }

    /**
     * @param mixed $thumb_width
     *
     * @return $this
     */
    public function setThumbWidth($thumb_width)
    {
        $this->thumb_width = $thumb_width;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getThumbHeight()
    {
        return $this->thumb_height;
    }

    /**
     * @param mixed $thumb_height
     *
     * @return $this
     */
    public function setThumbHeight($thumb_height)
    {
        $this->thumb_height = $thumb_height;

        return $this;
    }
}
