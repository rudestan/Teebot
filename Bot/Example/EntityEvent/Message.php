<?php

namespace Teebot\Bot\Example\EntityEvent;

use Teebot\Command\AbstractCommand;

class Message extends AbstractCommand
{
    /** @var Message $entity */
    protected $entity = null;

    public function run()
    {
        $this->sendMessage('Re: ' . $this->entity->getText() . "> reply");
    }
}
