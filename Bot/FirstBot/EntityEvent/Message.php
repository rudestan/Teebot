<?php

namespace Teebot\Bot\FirstBot\EntityEvent;

use Teebot\Api\Command\AbstractCommand;

class Message extends AbstractCommand
{
    /** @var Message $entity */
    protected $entity = null;

    public function run()
    {
        $this->sendMessage('Re: ' . $this->entity->getText() . "> reply");
    }
}
