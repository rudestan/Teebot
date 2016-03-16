<?php

namespace Teebot\Exception;

class Fatal extends AbstractException
{
    const COLOR_MESSAGE_PATTERN = "\e[0;31m%s\e[0m";
}
