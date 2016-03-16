<?php

namespace Teebot\Entity;

use Teebot\Exception\Critical;
use Teebot\Exception\Output;

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
            throw new Critical('File "' . $this->file . '" is not readable or does not exist!');
        }

        return new \CURLFile($this->file);
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

        try {
            $file = $this->initFileForUpload();
        } catch (\Exception $e) {
            Output::log($e);
        }

        return $file;
    }
}
