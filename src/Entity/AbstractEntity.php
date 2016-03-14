<?php

namespace Teebot\Entity;

abstract class AbstractEntity
{
    const ENTITY_TYPE = 'AbstractEntity';

    protected $parent;

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function __construct(array $data)
    {
        $this->setProperties($data);
    }

    public function getEntityType() : string
    {
        return static::ENTITY_TYPE;
    }

    protected function setProperties(array $data) {
        foreach ($data as $name => $value) {
            $name = str_replace(" ", "", lcfirst(ucwords(str_replace("_", " ", $name))));

            if (property_exists($this, $name)) {
                $this->{$name} = $value;
            }
        }
    }

    public function getProperties()
    {
        return array_filter(get_object_vars($this));
    }
}
