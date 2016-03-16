<?php

namespace Teebot\Entity;

use Teebot\Command\Executor;
use Teebot\Traits\Property;

abstract class AbstractEntity
{
    use Property;

    const ENTITY_TYPE = 'AbstractEntity';

    protected $parent;

    protected $builtInEntities = [];

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

    protected function initBuiltInEntities($data)
    {
        foreach ($this->builtInEntities as $name => $class) {
            if (!isset($data[$name])) {
                continue;
            }

            $data[$name] = class_exists($class) ? new $class($data[$name]) : null;
        }

        return $data;
    }
}
