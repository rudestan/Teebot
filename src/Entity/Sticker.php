<?php

namespace Teebot\Entity;

class Sticker extends AbstractEntity
{
    const ENTITY_TYPE = 'Sticker';

    protected $file_id;

    protected $width;

    protected $height;

    protected $thumb;

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
    public function getThumb()
    {
        return $this->thumb;
    }

    /**
     * @return mixed
     */
    public function getFileSize()
    {
        return $this->file_size;
    }
}
