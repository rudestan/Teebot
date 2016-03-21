<?php

namespace Teebot\Entity;

class Contact extends AbstractEntity
{
    const ENTITY_TYPE = 'Contact';

    protected $phone_number;

    protected $first_name;

    protected $last_name;

    protected $user_id;

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }
}
