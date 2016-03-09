<?php

namespace Teebot\Bot\FirstBot\Command;

use Teebot\Api\Command\AbstractCommand;

class Time extends AbstractCommand
{
    public function run()
    {
        $text = 'Current date and time: ' . date('d.m.Y H:i');
        $this->sendMessage($text);
    }
}
