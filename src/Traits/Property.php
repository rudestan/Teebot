<?php

namespace Teebot\Traits;

trait Property
{
    protected function setProperties(array $data)
    {
        foreach ($data as $name => $value) {

            $setterMethod = $this->getSetGetMethodName("set", $name);

            if ($setterMethod) {
                $this->{$setterMethod}($value);

                continue;
            }

            if (property_exists($this, $name)) {
                $this->{$name} = $value;
            }
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
}
