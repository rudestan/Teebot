<?php

namespace Teebot\Api\Entity;

class KeyboardButton extends AbstractEntity
{
    const ENTITY_TYPE = 'KeyboardButton';

    /** @var string $text */
    protected $text;

    /** @var string $request_contact */
    protected $request_contact;

    /** @var string $request_location */
    protected $request_location;

    protected $supportedProperties = [
        'text'                => true,
        'request_contact'     => false,
        'request_location'    => false,
    ];

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequestContact()
    {
        return $this->request_contact;
    }

    /**
     * @param string $request_contact
     *
     * @return $this
     */
    public function setRequestContact($request_contact)
    {
        $this->request_contact = $request_contact;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequestLocation()
    {
        return $this->request_location;
    }

    /**
     * @param string $request_location
     *
     * @return $this
     */
    public function setRequestLocation($request_location)
    {
        $this->request_location = $request_location;

        return $this;
    }
}
