<?php

namespace Teebot\Entity\Inline\Result;

class InlineQueryResultGif extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultGif';

    const RESULT_TYPE = 'gif';

    protected $gif_url;

    protected $gif_width;

    protected $gif_height;

    protected $caption;

    protected $supportedProperties = [
        'type'                     => true,
        'id'                       => true,
        'gif_url'                  => true,
        'gif_width'                => false,
        'gif_height'               => false,
        'thumb_url'                => true,
        'title'                    => false,
        'caption'                  => false,
        'reply_markup'             => false,
        'input_message_content'    => true,
    ];

    /**
     * @return mixed
     */
    public function getGifUrl()
    {
        return (string) $this->gif_url;
    }

    /**
     * @param string $gif_url
     *
     * @return $this
     */
    public function setGifUrl($gif_url)
    {
        $this->gif_url = $gif_url;

        return $this;
    }

    /**
     * @return int
     */
    public function getGifWidth()
    {
        return $this->gif_width;
    }

    /**
     * @param int $gif_width
     *
     * @return $this
     */
    public function setGifWidth($gif_width)
    {
        $this->gif_width = $gif_width;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGifHeight()
    {
        return $this->gif_height;
    }

    /**
     * @param int $gif_height
     *
     * @return $this
     */
    public function setGifHeight($gif_height)
    {
        $this->gif_height = $gif_height;

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
     *
     * @return $this
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }
}
