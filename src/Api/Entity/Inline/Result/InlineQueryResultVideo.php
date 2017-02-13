<?php

namespace Teebot\Api\Entity\Inline\Result;

class InlineQueryResultVideo extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultVideo';

    const RESULT_TYPE = 'video';

    const MIME_TYPE_HTML = 'text/html';

    const MIME_TYPE_MP4  = 'video/mp4';

    protected $video_url;

    protected $mime_type;

    protected $message_text;

    protected $video_width;

    protected $video_height;

    protected $video_duration;

    protected $description;

    protected $supportedProperties = [
        'type'                     => true,
        'id'                       => true,
        'video_url'                => true,
        'mime_type'                => true,
        'message_text'             => true,
        'title'                    => true,
        'parse_mode'               => false,
        'disable_web_page_preview' => false,
        'video_width'              => false,
        'video_height'             => false,
        'video_duration'           => false,
        'thumb_url'                => true,
        'description'              => false,
        'reply_markup'             => false,
        'input_message_content'    => true,
    ];

    /**
     * @return mixed
     */
    public function getVideoUrl()
    {
        return $this->video_url;
    }

    /**
     * @param mixed $video_url
     *
     * @return $this
     */
    public function setVideoUrl($video_url)
    {
        $this->video_url = $video_url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMimeType()
    {
        return $this->mime_type;
    }

    /**
     * @param mixed $mime_type
     *
     * @return $this
     */
    public function setMimeType($mime_type)
    {
        $this->mime_type = $mime_type;

        return $this;
    }

    /**
     * @return $this
     */
    public function setMimeTypeHTML()
    {
        $this->mime_type = static::MIME_TYPE_HTML;

        return $this;
    }

    /**
     * @return $this
     */
    public function setMimeTypeMp4()
    {
        $this->mime_type = static::MIME_TYPE_MP4;

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
    public function getVideoWidth()
    {
        return $this->video_width;
    }

    /**
     * @param mixed $video_width
     *
     * @return $this
     */
    public function setVideoWidth($video_width)
    {
        $this->video_width = $video_width;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVideoHeight()
    {
        return $this->video_height;
    }

    /**
     * @param mixed $video_height
     *
     * @return $this
     */
    public function setVideoHeight($video_height)
    {
        $this->video_height = $video_height;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVideoDuration()
    {
        return $this->video_duration;
    }

    /**
     * @param mixed $video_duration
     *
     * @return $this
     */
    public function setVideoDuration($video_duration)
    {
        $this->video_duration = $video_duration;

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
}
