<?php

namespace Teebot\Bot\Example\EntityEvent;

use Teebot\Command\AbstractCommand;

class User extends AbstractCommand
{
    /** @var \Teebot\Entity\User */
    protected $entity;

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
