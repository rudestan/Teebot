<?php

/**
 * Critical exception class
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Exception;

class Critical extends AbstractException
{
    const COLOR_MESSAGE_PATTERN = "\e[0;33m%s\e[0m";
}
