<?php

namespace Teebot\Api\Exception;

use \Exception;

class Critical extends Exception
{

    const RED_COLORED_MSG_PATTERN = "\e[0;33m%s\e[0m";

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        $message = sprintf(static::RED_COLORED_MSG_PATTERN, $message . "\n");

        parent::__construct($message, $code, $previous);
    }
}
