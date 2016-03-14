<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Entity\Message;

class Hi extends AbstractCommand
{
    /** @var Message $entity */
    protected $entity;

    public function run()
    {
        $text = sprintf(
            'Hello %s %s! How are you today?',
            $this->entity->getFrom()->getFirstName(),
            $this->entity->getFrom()->getLastName()
        );

        $this->sendMessage($text);
    }
}
