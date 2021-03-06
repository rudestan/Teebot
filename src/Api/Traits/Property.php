<?php

/**
 * Trait with methods to work with properties. Used in Method and Entity classes.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author  Stanislav Drozdov <rudestan@gmail.com>
 */

declare(strict_types=1);

namespace Teebot\Api\Traits;

use Teebot\Api\Exception\PropertyException;

trait Property
{
    /**
     * List of properties supported by method in format: property name => required or not
     *
     * @var array
     */
    protected $supportedProperties = [];

    /**
     * Returns camel cased property's getter or setter method name. Checks method for existence.
     *
     * @param string $prefix Prefix of the method e.g. "set" or "get"
     * @param string $name   Method's name
     *
     * @return null|string
     */
    protected function getSetGetMethodName(string $prefix, string $name): ?string
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
            $this->setProperty((string) $name, $value);
        }
    }

    /**
     * Sets property of the class.
     *
     * @param string     $name  Property name
     * @param null|mixed $value Value of the property
     */
    protected function setProperty(string $name, $value = null)
    {
        $setterMethod = $this->getSetGetMethodName("set", $name);

        if ($setterMethod !== null) {
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
    public function getPropertiesAsString(): string
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
    public function getPropertiesArray(bool $validate = true): array
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
            $this->validateProperties($properties);
        }

        return $properties;
    }

    /**
     * Returns multipart properties
     *
     * @param bool $validate
     *
     * @return array
     */
    public function getPropertiesMultipart(bool $validate = true): array
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
     * @throws PropertyException
     */
    protected function validateProperties(array $properties)
    {
        foreach ($this->supportedProperties as $propertyName => $isRequired) {
            if ($isRequired === true && empty($properties[$propertyName])) {
                throw new PropertyException('Required property "'.$propertyName.'" is not set!');
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
    public function asJson(bool $validate = true): string
    {
        $properties = $this->getPropertiesArray($validate);

        return json_encode($properties);
    }
}
