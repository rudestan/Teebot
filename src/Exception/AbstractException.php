<?php

/**
 * Abstract exception class
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Exception;

use \Exception;

class AbstractException extends Exception
{
    const COLOR_MESSAGE_PATTERN = "%s";

    /**
     * Returns color message pattern
     *
     * @return string
     */
    public function getColorMessagePattern()
    {
        return static::COLOR_MESSAGE_PATTERN;
    }

    /**
     * Returns exception type
     *
     * @return mixed
     */
    public function getType()
    {
        return static::class;
    }
}
