<?php

namespace Teebot\Bot\Example\EntityEvent;

use Teebot\Command\AbstractEntityEvent;

class Update extends AbstractEntityEvent
{
    public function run()
    {
        echo "I am triggered!\n";

        return true;
    }
}
