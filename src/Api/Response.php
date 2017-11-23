<?php

/**
 * Response class which should be instantiated from received or passed raw JSON string.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

declare(strict_types=1);

namespace Teebot\Api;

use Teebot\Api\Exception\{
    BuildEntityException,
    DecodingDataException
};
use Teebot\Api\Entity\{
    Update,
    EntityInterface,
    Error
};

class Response
{
    protected const DEFAULT_ENTITY_TYPE = Update::class;

    /**
     * @var array
     */
    protected $decodedData = [];

    /**
     * @var int
     */
    protected $lastUpdate = 0;

    /**
     * @var array
     */
    protected $entities = [];

    /**
     * @var null|EntityInterface
     */
    protected $parent;

    /**
     * Creates an instanse of Response class from Raw JSON string and builds corresponding entity
     * if passed in entity class. This class should be instantiated for every JSON response from Telegram.
     *
     * @param string               $rawData     Raw JSON string
     * @param null|string          $entityClass Entity class that should be instantiated with decoded JSON data
     * @param null|EntityInterface $parent      Parent class should be set as parent for newly instantiated entity
     *
     * @throws DecodingDataException
     */
    public function __construct(string $rawData, string $entityClass = null, EntityInterface $parent = null)
    {
        $this->parent      = $parent;
        $this->decodedData = $this->decodeData($rawData);

        if (empty($this->decodedData)) {
            throw new DecodingDataException('Error decoding data!');
        }

        $entityClass    = $this->isErrorReceived() ? Error::class : $entityClass;
        $entitiesSource = $this->getRawEntitiesList();
        $this->entities = $this->buildEntities($entitiesSource, $entityClass);
    }

    /**
     * Returns JSON data decoded as an array.
     *
     * @param string $rawData JSON string
     *
     * @return array
     */
    protected function decodeData(string $rawData): array
    {
        if (!is_string($rawData) || !strlen($rawData)) {
            return [];
        }

        try {
            $result = json_decode($rawData, true);
        } catch (\Exception $e) {
            return [];
        }

        return $result;
    }

    /**
     * Checks whether an error response from Telegram was received.
     *
     * @return bool
     */
    public function isErrorReceived(): bool
    {
        if ((isset($this->decodedData['ok']) && $this->decodedData['ok'] === true)) {
            return false;
        }

        return true;
    }

    /**
     * Builds entity objects array from an array of raw entity data. Returns an array with built entities.
     *
     * @param array       $rawData     Raw entity data array
     * @param null|string $entityClass Entity class
     *
     * @return array
     */
    protected function buildEntities(array $rawData, string $entityClass = null): array
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

            $entity = $this->buildEntity($rawItemData, $entityClass);

            if ($entity && $entity instanceof Update) {
                $this->lastUpdate = (int)$entity->getUpdateId();
            }

            $entities[] = $entity;
        }

        return $entities;
    }

    /**
     * Builds desired entity from raw entity's data array. Returns class entity
     *
     * @param array       $rawItemData Array with raw entity's data
     * @param null|string $entityClass Entity class to instantiate, if not passed - default Entity class will be used.
     *
     * @return EntityInterface
     *
     * @throws BuildEntityException
     */
    protected function buildEntity(array $rawItemData, $entityClass = null): EntityInterface
    {
        $entityClass = $entityClass ? $entityClass : static::DEFAULT_ENTITY_TYPE;
        $entity      = null;

        if (!class_exists($entityClass)) {
            throw new BuildEntityException('Entity "' . $entityClass . '" does not exists or not supported yet!');
        }

        /** @var EntityInterface $entity */
        $entity = new $entityClass($rawItemData);
        $entity->setParent($this->parent);

        return $entity;
    }

    /**
     * Returns an array with entities
     *
     * @return array
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    /**
     * Returns an entity at certain offset or null if entity does not exists.
     *
     * @param int $offset Offset
     *
     * @return EntityInterface|null
     */
    public function getEntityByOffset(int $offset = 0): ?EntityInterface
    {
        return is_array($this->entities) && isset($this->entities[$offset]) ? $this->entities[$offset] : null;
    }

    /**
     * Returns first entity. More meaningful wrapper for self::getEntityByOffset(0) method.
     *
     * @return EntityInterface|null
     */
    public function getFirstEntity(): ?EntityInterface
    {
        return $this->getEntityByOffset();
    }

    /**
     * Returns raw entities list from decoded JSON data array.
     *
     * @return array
     */
    protected function getRawEntitiesList(): array
    {
        if (!is_array($this->decodedData) || empty($this->decodedData)) {
            return [];
        }

        if (isset($this->decodedData['result']) && is_array($this->decodedData['result'])) {
            return $this->decodedData['result'];
        }

        return $this->decodedData;
    }

    /**
     * Returns count of entities.
     *
     * @return int
     */
    public function getEntitiesCount(): int
    {
        return count($this->entities);
    }

    /**
     * Returns last update id gathered from the last Update entity.
     *
     * @return int
     */
    public function getLastUpdate(): int
    {
        return $this->lastUpdate;
    }

    /**
     * Returns an offset to skip previous updates in the listener mode.
     *
     * @return int
     */
    public function getOffset(): int
    {
        return $this->lastUpdate + 1;
    }
}
