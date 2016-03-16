<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\SendLocation;

class Location extends AbstractCommand
{
    public function run()
    {
        $args = [
            'chat_id'   => $this->getChatId(),
            'latitude'  => 52.4927023,
            'longitude' => 13.3233105
        ];

        $method = new SendLocation($args);
        $method->trigger();
    }
}
