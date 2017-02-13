<?php

/**
 * Notice exception class
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Exception;

class Notice extends AbstractException
{
    const COLOR_MESSAGE_PATTERN = "\e[0;37m%s\e[0m";
}
