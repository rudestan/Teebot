<?php

namespace Teebot\Api\Entity;

use Teebot\Api\Exception\EntityException;

class InputFile
{
    const DEFAULT_MAX_SIZE = 50;

    protected $maxSize = self::DEFAULT_MAX_SIZE;

    protected $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    protected function initFileForUpload()
    {
        if (!$this->isFileReadable($this->file)) {
            throw new EntityException('File "' . $this->file . '" is not readable or does not exist!');
        }
        return fopen($this->file, 'r');
    }

    protected function isFileReadable($file)
    {
        return is_readable($file);
    }

    protected function isFileId($file)
    {
        return preg_match("/^\d*$/", $file);
    }

    public function getFileForUpload()
    {
        $file = $this->file;

        if ($this->isFileId($this->file)) {
            return $file;
        }

        return $this->initFileForUpload();
    }
}
