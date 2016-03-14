<?php

namespace Teebot\Entity;

abstract class AbstractEntity
{
    use \Teebot\Traits\Property;

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
}
