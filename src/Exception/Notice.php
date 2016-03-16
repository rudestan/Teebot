<?php

namespace Teebot\Exception;

class Notice extends AbstractException
{
    const COLOR_MESSAGE_PATTERN = "\e[0;37m%s\e[0m";
}
