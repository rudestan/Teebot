<?php

/**
 * Fatal exception class
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Exception;

class Fatal extends AbstractException
{
    const COLOR_MESSAGE_PATTERN = "\e[0;31m%s\e[0m";
}
