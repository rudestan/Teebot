<?php

namespace Teebot\Entity;

use Teebot\Entity\PhotoSize;

class UserProfilePhotos extends AbstractEntity
{
    const ENTITY_TYPE = 'UserProfilePhotos';

    const MAX_FILE_SIZE = 'max_file_size';

    const MIN_FILE_SIZE = 'min_file_size';

    protected $total_count;

    protected $photos;

    /**
     * @return mixed
     */
    public function getTotalCount()
    {
        return $this->total_count;
    }

    /**
     * @param mixed $total_count
     */
    public function setTotalCount($total_count)
    {
        $this->total_count = $total_count;
    }

    /**
     * @return mixed
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    public function getPhotoByOffset($offset = 0)
    {
        return is_array($this->photos) && isset($this->photos[0]) ? $this->photos[0] : null;
    }

    public function getPhotoWithMinFileSize()
    {
        return $this->getPhotoWithMinMaxFileSize(static::MIN_FILE_SIZE);
    }

    public function getPhotoWithMaxFileSize()
    {
        return $this->getPhotoWithMinMaxFileSize(static::MAX_FILE_SIZE);
    }

    protected function getPhotoWithMinMaxFileSize($minMax)
    {
        if (empty($this->photos) || !is_array($this->photos)) {
            return null;
        }

        $biggest = null;

        foreach ($this->photos as $photo) {
            if (!$photo instanceof PhotoSize) {
                continue;
            }

            $size      = $photo->getFileSize();
            $maxSize   = $biggest instanceof PhotoSize ? $biggest->getFileSize() : 0;
            $condition = $minMax == static::MAX_FILE_SIZE ? $size > $maxSize : $size < $maxSize;

            if (!$biggest || $condition) {
                $biggest = $photo;
            }
        }

        return $biggest;
    }

    /**
     * @param array $photos
     *
     * @return $this
     */
    public function setPhotos($photos)
    {
        $photoSizes = [];

        if (is_array($photos)) {
            foreach ($photos as $photoSizeArray) {
                foreach($photoSizeArray as $photoSizeData) {
                    if (!empty($photoSizeData)) {
                        $photoSizes[] = new PhotoSize($photoSizeData);
                    }
                }
            }
        }

        $this->photos = $photoSizes;

        return $this;
    }
}