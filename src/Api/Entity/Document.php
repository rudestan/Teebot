<?php

namespace Teebot\Api\Entity;

class Document extends AbstractEntity
{
    const ENTITY_TYPE = 'Document';

    protected $file_id;

    protected $thumb;

    protected $file_name;

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
    public function getThumb()
    {
        return $this->thumb;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->file_name;
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
