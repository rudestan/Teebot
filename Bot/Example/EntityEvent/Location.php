<?php

namespace Teebot\Bot\Example\EntityEvent;

use Teebot\Command\AbstractCommand;

class Location extends AbstractCommand
{
    public function run()
    {
        $text = 'Location!';

        $this->sendMessage($text);
    }
}
