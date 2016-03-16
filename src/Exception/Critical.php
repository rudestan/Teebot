<?php

namespace Teebot\Exception;

class Critical extends AbstractException
{
    const COLOR_MESSAGE_PATTERN = "\e[0;33m%s\e[0m";
}
