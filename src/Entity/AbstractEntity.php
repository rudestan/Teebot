<?php

/**
 * Base abstract class for supported by Telegram entity classes.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Entity;

use Teebot\Traits\Property;

abstract class AbstractEntity
{
    use Property;

    const ENTITY_TYPE = 'AbstractEntity';

    protected $parent;

    protected $builtInEntities = [];

    protected $supportedProperties = [];

    /**
     * Returns parent entity
     *
     * @return AbstractEntity
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Sets parent entity
     *
     * @param AbstractEntity $parent Parent entity
     */
    public function setParent(AbstractEntity $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Constructs extended entity's class and sets properties from array if passed.
     *
     * @param array $data Array with properties to set
     */
    public function __construct(array $data = [])
    {
        if (empty($data)) {
            return;
        }
        
        $this->setProperties($data);
        $this->initBuiltInEntities($data);
    }

    /**
     * Returns entity type
     *
     * @return string
     */
    public function getEntityType() : string
    {
        return static::ENTITY_TYPE;
    }

    /**
     * Initialises built-in entity classes if any.
     *
     * @param array $data Array with data to pass to newly created instance of built-in entity
     */
    protected function initBuiltInEntities(array $data)
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
