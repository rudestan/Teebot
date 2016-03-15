<?php

namespace Teebot;

use Teebot\Exception\Fatal;
use Teebot\Entity\AbstractEntity;
use Teebot\Entity\Message;
use Teebot\Entity\Error;
use Teebot\Exception\Critical;

class Response
{
    const DEFAULT_ENTITY_TYPE = Message::class;

    protected $decodedData = [];

    protected $lastUpdate = 0;

    protected $entities = [];

    protected $parent;

    public function __construct(string $rawData, $entityClass, $parent)
    {
        $this->parent      = $parent;
        $this->decodedData = $this->decodeData($rawData);

        if (empty($this->decodedData)) {
            throw new Critical('Error decoding data!');
        }

        $entityClass    = $this->isErrorReceived() ? Error::class : $entityClass;
        $entitiesSource = $this->getRawEntitiesList();
        $this->entities = $this->buildEntities($entitiesSource, $entityClass);
    }

    protected function decodeData($rawData) {
        if (!is_string($rawData) || !strlen($rawData)) {
            return [];
        }

        return json_decode($rawData, true);
    }

    public function isErrorReceived() {
        if (isset($this->decodedData['ok']) && $this->decodedData['ok'] === true) {
            return false;
        }

        return true;
    }

    public function getEntities() : array
    {
        return $this->entities;
    }

    protected function getRawEntitiesList() : array
    {
        return $this->decodedData['result'] ?? $this->decodedData;
    }

    protected function buildEntities(array $rawData, $entityClass = null) : array
    {
        $entities = [];
        $entity   = null;

        if (empty($rawData)) {
            return $entities;
        }

        if (!isset($rawData[0])) {
            $rawData = [$rawData];
        }

        foreach ($rawData as $rawItemData) {
            if (empty($rawItemData)) {
                continue;
            }

            try {
                $entity = $this->buildEntity($rawItemData, $entityClass);

                $entities[] = $entity;

                if ($entity && $entity instanceof Message) {
                    $this->lastUpdate = (int) $entity->getUpdateId();
                }

            } catch (Fatal $e) {
                echo $e->getMessage();
            }
        }

        return $entities;
    }

    protected function buildEntity(array $rawItemData, $entityClass = null) : AbstractEntity
    {
        $entityClass = $entityClass ?? static::DEFAULT_ENTITY_TYPE;
        $entity = null;

        if (!class_exists($entityClass)) {
            throw new Critical('Entity "'.$entityClass.'" does not exists or not supported yet!');
        }
        /** @var AbstractEntity $entity */
        $entity = new $entityClass($rawItemData);
        $entity->setParent($this->parent);

        return $entity;
    }

    public function getEntitiesCount() : int {
        return count($this->entities);
    }

    public function getLastUpdate() : int {
        return $this->lastUpdate;
    }

    public function getOffset() : int
    {
        return $this->lastUpdate + 1;
    }
}
