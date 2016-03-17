<?php

namespace Teebot\Traits;

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
}
