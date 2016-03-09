<?php

namespace Teebot\Api;

use Teebot\Api\Exception\Fatal;
use Teebot\Api\Entity\AbstractEntity;
use Teebot\Api\Entity\Message;
use Teebot\Api\Entity\Error;
use Teebot\Api\Exception\Critical;

class Response
{
    const ENTITY_PATTERN = 'Teebot\\Api\\Entity\\%s';

    const DEFAULT_ENTITY_TYPE = Message::TYPE;

    protected $decodedData = [];

    protected $lastUpdate = 0;

    protected $entities = [];

    protected $parent;

    public function __construct(string $rawData, $entityType, $parent)
    {
        $this->parent      = $parent;
        $this->decodedData = $this->decodeData($rawData);

        if (empty($this->decodedData)) {
            throw new Critical('Error decoding data!');
        }

        $entityType     = $this->isErrorReceived() ? Error::TYPE : $entityType;
        $entitiesSource = $this->getRawEntitiesList();
        $this->entities = $this->buildEntities($entitiesSource, $entityType);
    }

    /**
     * @return mixed
     */
    public function getCaller()
    {
        return $this->caller;
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

    protected function buildEntities(array $rawData, $entityType = null) : array
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
                $entity = $this->buildEntity($rawItemData, $entityType);

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

    protected function getEntityClassName($entityType)
    {
        $entityType = $entityType ?? static::DEFAULT_ENTITY_TYPE;

        return sprintf(static::ENTITY_PATTERN, $entityType);
    }

    protected function buildEntity(array $rawItemData, $entityType = null) : AbstractEntity
    {
        $entityClassName = $this->getEntityClassName($entityType);
        $entity = null;

        if (!class_exists($entityClassName)) {
            throw new Fatal('Entity "'.$entityType.'" does not exists or not supported yet!');
        }
        /** @var AbstractEntity $entity */
        $entity = new $entityClassName($rawItemData);
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
