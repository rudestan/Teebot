<?php

namespace Teebot\Entity\Inline\Result;

class InlineQueryResultMpeg4Gif extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultMpeg4Gif';

    const RESULT_TYPE = 'mpeg4_gif';

    protected $mpeg4_url;

    protected $mpeg4_width;

    protected $mpeg4_height;

    protected $caption;

    protected $supportedProperties = [
        'type'                  => true,
        'id'                    => true,
        'mpeg4_url'             => true,
        'mpeg4_width'           => false,
        'mpeg4_height'          => false,
        'thumb_url'             => false,
        'title'                 => false,
        'caption'               => false,
        'reply_markup'          => false,
        'input_message_content' => true,
    ];

    /**
     * @return mixed
     */
    public function getMpeg4Url()
    {
        return $this->mpeg4_url;
    }

    /**
     * @param mixed $mpeg4_url
     *
     * @return $this
     */
    public function setMpeg4Url($mpeg4_url)
    {
        $this->mpeg4_url = $mpeg4_url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMpeg4Width()
    {
        return $this->mpeg4_width;
    }

    /**
     * @param mixed $mpeg4_width
     *
     * @return $this
     */
    public function setMpeg4Width($mpeg4_width)
    {
        $this->mpeg4_width = $mpeg4_width;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMpeg4Height()
    {
        return $this->mpeg4_height;
    }

    /**
     * @param mixed $mpeg4_height
     *
     * @return $this
     */
    public function setMpeg4Height($mpeg4_height)
    {
        $this->mpeg4_height = $mpeg4_height;

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
