<?php

namespace Teebot\Bot\Example\EntityEvent;

use Teebot\Command\AbstractEntityEvent;

class Command extends AbstractEntityEvent
{
    public function run()
    {
        return true;
    }
}
