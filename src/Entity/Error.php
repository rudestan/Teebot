<?php

namespace Teebot\Entity;

class Error extends AbstractEntity
{
    const ENTITY_TYPE = 'Error';

    protected $errorCode;

    protected $description;

    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }
}
