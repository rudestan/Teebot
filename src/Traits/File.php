<?php

/**
 * Trait with methods to handle file uploads via CURL.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author  Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Traits;

use Teebot\Entity\InputFile;
use \CURLFile;

trait File
{
    /**
     * Creates an InputFile instance for handling file uploads.
     *
     * @param string $file Full path to the file
     *
     * @return \CURLFile
     */
    protected function initInputFile($file)
    {
        $inputFile = new InputFile($file);
        $file      = $inputFile->getFileForUpload();

        if ($file instanceof CURLFile) {
            $this->hasAttachedData = ($file instanceof CURLFile);
        }

        return $file;
    }
}
