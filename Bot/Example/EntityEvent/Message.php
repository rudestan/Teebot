<?php

namespace Teebot\Bot\Example\EntityEvent;

use Teebot\Command\AbstractCommand;

class Message extends AbstractCommand
{
    /** @var \Teebot\Entity\Message $entity */
    protected $entity = null;

    public function run()
    {
        $this->getChatId();

        $this->sendMessage('Current chat id: '.$this->getChatId());
    }
}
