<?php

namespace Teebot\Method;

use Teebot\Exception\Critical;
use Teebot\Command\Executor;

abstract class AbstractMethod {

    use \Teebot\Traits\Property;

    const NAME            = null;

    const RETURN_ENTITY   = null;

    const HAS_BINARY_DATA = false;

    protected $supportedProperties = [];

    public function __construct($args = [])
    {
        try {
            $this->validateArgs($args);
        } catch (Critical $e) {
            echo $e->getMessage();

            return;
        }

        $this->setProperties($args);
    }

    public function getName()
    {
        return static::NAME;
    }

    public function getReturnEntity()
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
                throw new Critical('Required property "'.$property.'" is not set!');
            }
        }
    }

    public function send($parent, $silentMode = true)
    {
        $executor = Executor::getInstance();

        return $executor->callRemoteMethod($this, $silentMode, $parent);
    }
}
