<?php

/**
 * Trait with methods to handle file uploads via CURL.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author  Stanislav Drozdov <rudestan@gmail.com>
 */

declare(strict_types=1);

namespace Teebot\Api\Traits;

use Teebot\Api\Entity\InputFile;

trait File
{
    /**
     * Creates an InputFile instance for handling file uploads.
     *
     * @param string $file Full path to the file
     *
     * @return \CURLFile
     */
    protected function initInputFile(string $file)
    {
        $inputFile = new InputFile($file);
        $file      = $inputFile->getFileForUpload();

        if ($file) {
            $this->hasAttachedData = true;
        }

        return $file;
    }
}
