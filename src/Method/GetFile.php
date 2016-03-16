<?php

namespace Teebot\Method;

use Teebot\Entity\File;

class GetFile extends AbstractMethod
{
    const NAME          = 'getFile';

    const RETURN_ENTITY = File::class;

    protected $file_id;

    protected $supportedProperties = [
        'file_id' => true
    ];

    /**
     * @return mixed
     */
    public function getFileId()
    {
        return $this->file_id;
    }

    /**
     * @param mixed $file_id
     *
     * @return $this
     */
    public function setFileId($file_id)
    {
        $this->file_id = $file_id;

        return $this;
    }
}
