<?php

namespace Teebot\Bot\FirstBot\Command;

use Teebot\Api\Command\AbstractCommand;

class Hi extends AbstractCommand
{
    public function run()
    {
        $text = sprintf(
            'Hello %s %s! How are you today?',
            $this->entity->getFromFirstName(),
            $this->entity->getFromLastName()
        );

        $this->sendMessage($text);
    }
}
