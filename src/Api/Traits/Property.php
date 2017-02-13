<?php

/**
 * Trait with methods to work with properties. Used in Method and Entity classes.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author  Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Traits;

use Teebot\Api\Exception\Output;
use Teebot\Api\Exception\Critical;

trait Property
{
    /**
     * Returns camel cased property's getter or setter method name. Checks method for existence.
     *
     * @param string $prefix Prefix of the method e.g. "set" or "get"
     * @param string $name   Method's name
     *
     * @return null|string
     */
    protected function getSetGetMethodName($prefix, $name)
    {
        $setter = $prefix . str_replace("_", "", ucwords($name, "_"));

        if (method_exists($this, $setter)) {
            return $setter;
        }

        return null;
    }

    /**
     * Sets properties of the class from array.
     *
     * @param array $data An associative array with property => value data
     */
    protected function setProperties(array $data)
    {
        foreach ($data as $name => $value) {
            $this->setProperty($name, $value);
        }
    }

    /**
     * Sets property of the class.
     *
     * @param string     $name  Property name
     * @param null|mixed $value Value of the property
     */
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

    /**
     * Returns properties as string. Used for building get query string if GET method was set.
     *
     * @return string
     */
    public function getPropertiesAsString()
    {
        $properties = $this->getPropertiesArray();

        return $properties ? http_build_query($properties) : '';
    }

    /**
     * Returns an array with properties. Array with supported properties should be defined
     * in the class.
     *
     * @param bool $validate Flag whether validation for required properties should be applied
     *
     * @return array
     */
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

    public function getPropertiesMultipart($validate = true)
    {
        $requestProperties = [];
        $properties        = $this->getPropertiesArray($validate);

        foreach ($properties as $k => $v) {
            $requestProperties[] = [
                'name'     => $k,
                'contents' => $v,
            ];
        }

        return $requestProperties;
    }

    /**
     * Validates properties and checks which are required
     *
     * @param array $properties An associative array of the properties
     *
     * @throws Critical
     */
    protected function validateProperties($properties)
    {
        foreach ($this->supportedProperties as $propertyName => $isRequired) {
            if ($isRequired === true && empty($properties[$propertyName])) {
                throw new Critical('Required property "'.$propertyName.'" is not set!');
            }
        }
    }

    /**
     * Returns object's properties encoded as JSON string
     *
     * @param bool $validate Flag whether validation for required properties should be applied
     *
     * @return string
     */
    public function asJson($validate = true)
    {
        $properties = $this->getPropertiesArray($validate);

        return json_encode($properties);
    }
}
