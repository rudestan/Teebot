<?php

namespace Teebot\Api\Command;

/**
 * Interface EventInterface
 */
interface CommandInterface extends EventInterface
{
    /**
     * Sets argument string for the command
     *
     * @param string $args Arguments string
     */
    public function setArgs($args);

    /**
     * Returns arguments string for the command
     *
     * @return string
     */
    public function getArgs();
}
