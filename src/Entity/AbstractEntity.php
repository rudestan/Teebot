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

    protected $supportedProperties = [];

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

    public function __construct(array $data = [])
    {
        if (empty($data)) {
            return;
        }
        
        $this->setProperties($data);
        $this->initBuiltInEntities($data);
    }

    public function getEntityType() : string
    {
        return static::ENTITY_TYPE;
    }

    protected function initBuiltInEntities($data)
    {
        if (empty($this->builtInEntities)) {
            return;
        }

        foreach ($this->builtInEntities as $name => $class) {

            $initValues = null;

            if (property_exists($this, $name)) {
                if (isset($this->{$name})) {
                    $initValues = $this->{$name};
                } elseif (isset($data[$name])) {
                    $initValues = $data[$name];
                }
            }

            if ($initValues) {
                $object = class_exists($class) ? new $class($initValues) : null;
                $this->setProperty($name, $object);
            }
        }
    }
}
