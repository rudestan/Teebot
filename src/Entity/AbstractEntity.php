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

    public function __construct(array $data = null)
    {
        $this->setProperties($data);
        $this->initBuiltInEntities();
    }

    public function getEntityType() : string
    {
        return static::ENTITY_TYPE;
    }

    protected function initBuiltInEntities()
    {
        if (empty($this->builtInEntities)) {
            return;
        }

        foreach ($this->builtInEntities as $name => $class) {

            $initValues = null;

            if (property_exists($this, $name)) {
                $initValues = $this->{$name};
            }

            if ($initValues) {
                $object = class_exists($class) ? new $class($initValues) : null;
                $this->setProperty($name, $object);
            }
        }
    }
}
