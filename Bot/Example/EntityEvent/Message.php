<?php

namespace Teebot\Bot\Example\EntityEvent;

use Teebot\Command\AbstractCommand;
use Teebot\Method\SendChatAction;
use Teebot\Method\SendMessage;

class Message extends AbstractCommand
{
    /** @var \Teebot\Entity\Message $entity */
    protected $entity = null;

    public function run()
    {
        $this->sendMessage('Current chat id: '.$this->getChatId());
    }
}
