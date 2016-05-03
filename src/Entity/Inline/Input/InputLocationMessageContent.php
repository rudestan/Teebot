<?php

namespace Teebot\Entity\Inline\Input;

class InputLocationMessageContent extends InputMessageContentAbstract
{
    const ENTITY_TYPE = 'InputLocationMessageContent';

    protected $latitude;

    protected $longitude;

    protected $supportedProperties = [
        'latitude'  => true,
        'longitude' => true
    ];

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     *
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     *
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }
}
