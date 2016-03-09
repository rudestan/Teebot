<?php

namespace Teebot\Entity;

class User extends AbstractEntity
{
    const TYPE = 'User';

    protected $id;

    protected $firstName;

    protected $userName;

    protected function setProperties(array $data)
    {
        $this->id = $data['id'];
        $this->firstName = $data['first_name'];
        $this->userName = $data['username'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }
}
