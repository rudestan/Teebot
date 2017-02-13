<?php

namespace Teebot\Api\Entity\Inline\Input;

class InputVenueMessageContent extends InputMessageContentAbstract
{
    const ENTITY_TYPE = 'InputVenueMessageContent';

    protected $latitude;

    protected $longitude;

    protected $title;

    protected $address;

    protected $foursquare_id;

    protected $supportedProperties = [
        'latitude'      => true,
        'longitude'     => true,
        'title'         => true,
        'address'       => true,
        'foursquare_id' => false
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

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     *
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFoursquareId()
    {
        return $this->foursquare_id;
    }

    /**
     * @param mixed $foursquare_id
     *
     * @return $this
     */
    public function setFoursquareId($foursquare_id)
    {
        $this->foursquare_id = $foursquare_id;

        return $this;
    }
}
