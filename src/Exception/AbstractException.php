<?php

namespace Teebot\Exception;

use \Exception;

class AbstractException extends Exception
{
    const COLOR_MESSAGE_PATTERN = "%s";

    public function getColorMessagePattern()
    {
        return static::COLOR_MESSAGE_PATTERN;
    }

    public function getType()
    {
        return static::class;
    }
}
