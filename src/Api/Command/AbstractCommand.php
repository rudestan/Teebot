<?php

/**
 * Abstract command event class is base class for creating the command for received in response messages.
 * Most methods are inherited from AbstractEntityEvent since command is actually and AbstractEntityEvent
 * itself.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author  Stanislav Drozdov <rudestan@gmail.com>
 */

declare(strict_types=1);

namespace Teebot\Api\Command;

abstract class AbstractCommand extends AbstractEntityEvent implements CommandInterface
{
    /**
     * @var string
     */
    protected $args = '';

    /**
     * Sets argument string for the command
     *
     * @param string $args Arguments string
     */
    public function setArgs(string $args)
    {
        $this->args = $args;
    }

    /**
     * Returns arguments string for the command
     *
     * @return string
     */
    public function getArgs(): string
    {
        return $this->args;
    }
}
