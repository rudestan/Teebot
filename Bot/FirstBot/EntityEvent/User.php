<?php

namespace Teebot\Bot\FirstBot\EntityEvent;

use Teebot\Api\Command\AbstractCommand;

class User extends AbstractCommand
{
    public function run()
    {
        $text = sprintf(
            'My name is %s and username @%s',
            $this->entity->getFirstName(),
            $this->entity->getUserName()
        );

        $this->sendMessage($text);
    }
}
