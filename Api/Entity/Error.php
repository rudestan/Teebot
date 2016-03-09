<?php

namespace Teebot\Api\Entity;

class Error extends AbstractEntity
{
    const TYPE = 'Error';

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

    protected function setProperties(array $data)
    {
        $this->errorCode = $data['error_code'];
        $this->description = $data['description'];
    }
}
