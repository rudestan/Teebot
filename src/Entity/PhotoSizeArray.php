<?php

namespace Teebot\Entity;

class PhotoSizeArray extends AbstractEntity
{
    const ENTITY_TYPE   = 'Photo';

    const MAX_FILE_SIZE = 'max_file_size';

    const MIN_FILE_SIZE = 'min_file_size';

    protected $photoSizes;

    public function __construct(array $data)
    {
        if (empty($data)) {
            return;
        }

        $photoSizes = $this->initPhotoSizesFromData($data);

        $this->setPhotoSizes($photoSizes);
    }

    /**
     * @return mixed
     */
    public function getPhotoSizes()
    {
        return $this->photoSizes;
    }

    /**
     * @param mixed $photoSizes
     */
    public function setPhotoSizes($photoSizes)
    {
        $this->photoSizes = $photoSizes;
    }

    protected function initPhotoSizesFromData($data)
    {
        $photoSizes = [];

        foreach ($data as $photoSizeData) {
            if (!empty($photoSizeData)) {
                $photoSizes[] = new PhotoSize($photoSizeData);
            }
        }

        return $photoSizes;
    }

    public function getPhotoSizeWithMinFileSize()
    {
        return $this->getPhotoSizeWithMinMaxFileSize(static::MIN_FILE_SIZE);
    }

    public function getPhotoWithMaxFileSize()
    {
        return $this->getPhotoSizeWithMinMaxFileSize(static::MAX_FILE_SIZE);
    }

    protected function getPhotoSizeWithMinMaxFileSize($minMax)
    {
        $minMaxPhotoSize = null;

        foreach ($this->photoSizes as $photoSize) {
            if (!$photoSize instanceof PhotoSize) {
                continue;
            }

            $size      = $photoSize->getFileSize();
            $maxSize   = $minMaxPhotoSize instanceof PhotoSize ? $minMaxPhotoSize->getFileSize() : 0;
            $condition = $minMax == static::MAX_FILE_SIZE ? $size > $maxSize : $size < $maxSize;

            if (!$minMaxPhotoSize || $condition) {
                $minMaxPhotoSize = $photoSize;
            }
        }

        return $minMaxPhotoSize;
    }
}