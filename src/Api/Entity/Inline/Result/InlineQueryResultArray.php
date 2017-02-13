<?php

namespace Teebot\Api\Entity\Inline\Result;

use Teebot\Api\Entity\AbstractEntity;

class InlineQueryResultArray
{
    protected $entities;

    public function addEntity($entity)
    {
        $this->entities[] = $entity;

        return $this;
    }

    public function getEncodedEntities()
    {
        $result = [];

        /** @var AbstractEntity $entity */
        foreach ($this->entities as $entity) {
            $properties = $entity->getPropertiesArray();
            $result[]   = $properties;
        }

        return json_encode($result);
    }
}
