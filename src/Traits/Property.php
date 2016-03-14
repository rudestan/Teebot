<?php

namespace Teebot\Traits;

trait Property
{
    protected function setProperties(array $data) {
        foreach ($data as $name => $value) {

            if (property_exists($this, $name)) {
                $this->{$name} = $value;
            }
        }
    }
}
