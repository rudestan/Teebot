<?php

namespace Teebot\Api\Method;

interface MethodInterface
{
    /**
     * Constructs extended method's class and sets properties from array if passed.
     *
     * @param array $args
     */
    public function __construct($args = []);

    /**
     * Returns method's name.
     *
     * @return string
     */
    public function getName();

    /**
     * Returns entity's name that should be return in method execution result.
     *
     * @return string
     */
    public function getReturnEntity();

    /**
     * Returns parent entity which triggered method's execution.
     *
     * @return MethodInterface
     */
    public function getParent();

    /**
     * Sets parent entity which triggered method's execution.
     *
     * @param MethodInterface $parent
     *
     * @return $this
     */
    public function setParent(MethodInterface $parent);
}
