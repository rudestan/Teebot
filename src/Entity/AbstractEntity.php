<?php

namespace Teebot\Entity;

abstract class AbstractEntity
{
    const TYPE = 'AbstractEntity';

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

    public function __construct(array $data = null)
    {
        $this->setProperties($data);
    }

    public function getType() : string
    {
        return static::TYPE;
    }

    protected function getPropertyByPath($path, $data)
    {
        $value = null;
        $parts = explode('.', trim($path, '.'));
        $count = count($parts);

        for ($i = 0; $i < $count; $i++) {
            $part = $parts[$i];

            if (isset($data[$part])) {
                $value = is_array($data[$part]) && $i != $count - 1 ?
                    $this->getPropertyByPath($path, $data[$part]) : $data[$part];
            }
        }

        return $value;
    }

    abstract protected function setProperties(array $data);

    public function getProperties()
    {
        return array_filter(get_object_vars($this));
    }
}
