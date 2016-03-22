<?php

namespace Teebot\Bot\Example\EntityEvent;

use Teebot\Command\AbstractEntityEvent;

class Message extends AbstractEntityEvent
{
    public function run()
    {
        echo "Message received!";

        return true;
    }
}
