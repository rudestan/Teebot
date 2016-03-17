<?php

namespace Teebot\Entity;

class Video extends AbstractEntity
{
    const ENTITY_TYPE = 'Video';

    protected $file_id;

    protected $width;

    protected $height;

    protected $duration;

    protected $thumb;

    protected $mime_type;

    protected $file_size;

    protected $builtInEntities = [
        'thumb' => PhotoSize::class
    ];

    /**
     * @return mixed
     */
    public function getFileId()
    {
        return $this->file_id;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return mixed
     */
    public function getThumb()
    {
        return $this->thumb;
    }

    /**
     * @return mixed
     */
    public function getMimeType()
    {
        return $this->mime_type;
    }

    /**
     * @return mixed
     */
    public function getFileSize()
    {
        return $this->file_size;
    }
}
