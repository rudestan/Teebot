<?php

namespace Teebot\Entity;

class User extends AbstractEntity
{
    const ENTITY_TYPE = 'User';

    protected $id;

    protected $firstName;

    protected $lastName;

    protected $username;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->username;
    }
}
