<?php

namespace Teebot\Api\Entity;

/**
 * Interface EntityInterface
 */
interface EntityInterface
{
    /**
     * Constructs extended entity's class and sets properties from array if passed.
     *
     * @param array $data Array with properties to set
     */
    public function __construct(array $data);

    /**
     * Returns entity type
     *
     * @return string
     */
    public function getEntityType();

    /**
     * @param EntityInterface|null $parent
     */
    public function setParent(EntityInterface $parent = null);

    /**
     * @return EntityInterface|null
     */
    public function getParent();
}
