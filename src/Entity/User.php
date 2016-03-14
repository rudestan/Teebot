<?php

namespace Teebot\Entity;

class User extends AbstractEntity
{
    const ENTITY_TYPE = 'User';

    protected $id;

    protected $first_name;

    protected $last_name;

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
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->username;
    }
}
