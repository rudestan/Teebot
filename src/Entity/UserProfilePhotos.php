<?php

namespace Teebot\Entity;

class UserProfilePhotos extends AbstractEntity
{
    const ENTITY_TYPE   = 'UserProfilePhotos';

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
     * @param array $photos
     *
     * @return $this
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;

        if (is_array($photos)) {
            $this->photos = [];

            foreach ($photos as $photo) {
                $this->photos[] = new PhotoSizeArray($photo);
            }
        }

        return $this;
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
        return is_array($this->photos) && isset($this->photos[$offset]) ? $this->photos[0] : null;
    }
}