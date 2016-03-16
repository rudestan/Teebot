<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\SendChatAction;
use Teebot\Method\SendMessage;

class ActionTyping extends AbstractCommand
{
    public function run()
    {
        (new SendChatAction())
            ->setChatId($this->getChatId())
            ->setAction(SendChatAction::ACTION_TYPING)
            ->trigger();

        sleep(3);

        (new SendMessage())
            ->setChatId($this->getChatId())
            ->setText('Test message is here')
            ->trigger();
    }
}
