<?php

namespace Teebot\Exception;

use \Exception;

class Fatal extends Exception
{

    const RED_COLORED_MSG_PATTERN = "\e[0;31m%s\e[0m";

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        $message = sprintf(static::RED_COLORED_MSG_PATTERN, $message . "\n");

        parent::__construct($message, $code, $previous);
    }
}
