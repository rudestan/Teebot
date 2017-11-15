<?php

namespace Teebot\Api\Command;

use Teebot\Api\Entity\EntityInterface;

/**
 * Interface EventInterface
 */
interface EventInterface
{
    /**
     * Runs event
     */
    public function run();

    /**
     * Sets configuration parameters
     *
     * @param array $params
     *
     * @return EventInterface
     */
    public function setParams(array $params);

    /**
     * Sets entities processor
     *
     * @param Processor $processor
     *
     * @return EventInterface
     */
    public function setProcessor(Processor $processor);

    /**
     * Set entity that called the event
     *
     * @param EntityInterface $entity
     *
     * @return EventInterface
     */
    public function setEntity(EntityInterface $entity);
}
