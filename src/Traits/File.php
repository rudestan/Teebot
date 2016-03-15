<?php

namespace Teebot\Traits;

use Teebot\Entity\InputFile;

trait File
{
    protected function initInputFile($file)
    {
        $inputFile = new InputFile($file);
        $file      = $inputFile->getFileForUpload();

        if ($file instanceof \CURLFile) {
            $this->hasAttachedData = ($file instanceof \CURLFile);
        }

        return $file;
    }
}
