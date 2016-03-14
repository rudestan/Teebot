<?php

namespace Teebot\Method;

use Teebot\Exception\Fatal;

abstract class AbstractMethod {

    use \Teebot\Traits\Property;

    const NAME          = null;

    const RETURN_ENTITY = null;

    protected $supportedProperties = [];

    public function __construct($args = [])
    {
        try {
            $this->validateArgs($args);
        } catch (Fatal $e) {
            echo $e->getMessage();
            exit();
        }

        $this->setProperties($args);
    }

    public function getName()
    {
        return static::NAME;
    }

    public function getReturnEntityType()
    {
        return static::RETURN_ENTITY;
    }

    public function getPropertiesAsString()
    {
        $properties = $this->getPropertiesAsArray();

        return $properties ? http_build_query($properties) : '';
    }

    public function getPropertiesAsArray()
    {
        $properties = [];

        foreach ($this->supportedProperties as $name => $isRequired) {

            if (property_exists($this, $name)) {
                $properties[$name] = $this->{$name};
            }
        }

        return $properties;
    }

    protected function validateArgs($args)
    {
        foreach ($this->supportedProperties as $property => $isRequired) {
            if ($isRequired === true && empty($args[$property])) {
                throw new Fatal('Required property "'.$property.'" is not set!');
            }
        }
    }
}
