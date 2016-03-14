<?php

namespace Teebot\Entity;

class Error extends AbstractEntity
{
    const ENTITY_TYPE = 'Error';

    protected $error_code;

    protected $description;

    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->error_code;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }
}
