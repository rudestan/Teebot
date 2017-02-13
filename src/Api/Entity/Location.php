<?php

namespace Teebot\Api\Entity;

class Location extends AbstractEntity
{
    const ENTITY_TYPE = 'Location';

    protected $longitude;

    protected $latitude;

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }
}