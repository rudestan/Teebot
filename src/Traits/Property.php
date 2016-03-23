<?php

namespace Teebot\Traits;

use Teebot\Exception\Output;
use Teebot\Exception\Critical;

trait Property
{
    protected function setProperties(array $data)
    {
        foreach ($data as $name => $value) {
            $this->setProperty($name, $value);
        }
    }

    protected function getSetGetMethodName($prefix, $name)
    {
        $setter = $prefix . str_replace("_", "", ucwords($name, "_"));

        if (method_exists($this, $setter)) {
            return $setter;
        }

        return null;
    }

    protected function setProperty($name, $value = null)
    {
        $setterMethod = $this->getSetGetMethodName("set", $name);

        if ($setterMethod) {
            $this->{$setterMethod}($value);

            return;
        }

        if (property_exists($this, $name)) {
            $this->{$name} = $value;
        }
    }

    public function getPropertiesAsString()
    {
        $properties = $this->getPropertiesArray();

        return $properties ? http_build_query($properties) : '';
    }

    public function getPropertiesArray($validate = true)
    {
        $properties = [];

        if (empty($this->supportedProperties)) {
            return $properties;
        }

        foreach ($this->supportedProperties as $name => $isRequired) {

            $getterMethod = $this->getSetGetMethodName("get", $name);

            if ($getterMethod && $this->{$getterMethod}() !== null) {
                $properties[$name] = $this->{$getterMethod}();

                continue;
            }

            if (property_exists($this, $name) && $this->{$name} !== null) {
                $properties[$name] = $this->{$name};
            }
        }

        if ($validate) {
            try {
                $this->validateProperties($properties);
            } catch (Critical $e) {
                Output::log($e);

                $properties = [];
            }
        }

        return $properties;
    }

    protected function validateProperties($properties)
    {
        foreach ($this->supportedProperties as $propertyName => $isRequired) {
            if ($isRequired === true && empty($properties[$propertyName])) {
                throw new Critical('Required property "'.$propertyName.'" is not set!');
            }
        }
    }
}
