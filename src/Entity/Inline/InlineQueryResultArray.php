<?php

namespace Teebot\Entity\Inline;

use Teebot\Entity\AbstractEntity;

class InlineQueryResultArray extends AbstractEntity
{
    const ENTITY_TYPE = 'InlineQueryResultArray';

    protected $entities;

    public function addEntity($entity)
    {
        $this->entities[] = $entity;
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
