<?php

namespace Teebot\Api\Entity;

use Teebot\Api\Exception\EntityException;

class File extends AbstractEntity
{
    const ENTITY_TYPE = 'File';

    protected $file_id;

    protected $file_size;

    protected $file_path;

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

    /**
     * @return mixed
     */
    public function getFileSize()
    {
        return $this->file_size;
    }

    /**
     * @param mixed $file_size
     *
     * @return $this
     */
    public function setFileSize($file_size)
    {
        $this->file_size = $file_size;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFilePath()
    {
        return $this->file_path;
    }

    /**
     * @param mixed $file_path
     *
     * @return $this
     */
    public function setFilePath($file_path)
    {
        $this->file_path = $file_path;

        return $this;
    }

    public function download($storePath)
    {
        if (file_exists($storePath) && !is_writable($storePath)) {
            throw new EntityException('File "' . $storePath . '" is already exist!"');
        }

        $filePath = $this->getFilePath();

        if (!$filePath) {
            throw new EntityException('Unable to get path to file!');
        }

        try {
            $contents = file_get_contents($filePath);

            file_put_contents($storePath, $contents);
        } catch (\Exception $e) {
            throw new EntityException($e->getMessage(), $e->getCode(), $e);
        }

        return is_readable($storePath);
    }
}