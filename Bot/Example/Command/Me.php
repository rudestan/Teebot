<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\SendMessage;

class Me extends AbstractCommand
{
    public function run()
    {
        $sendMessage = (new SendMessage())
            ->setText('Me triggered!');

        $this->reply($sendMessage);
    }
}
