<?php

namespace Teebot\Api\Command\ValueObject;

use Teebot\Api\Entity\EntityInterface;

class ChainItem
{
    /**
     * @var EntityInterface
     */
    protected $entity;

    /**
     * @var EntityInterface
     */
    protected $parent;

    public function __construct(EntityInterface $entity, EntityInterface $parent = null)
    {
        $this->entity = $entity;
        $this->parent = $parent;
    }

    /**
     * @return EntityInterface
     */
    public function getEntity(): EntityInterface
    {
        return $this->entity;
    }

    /**
     * @return EntityInterface
     */
    public function getParent(): EntityInterface
    {
        return $this->parent;
    }
}