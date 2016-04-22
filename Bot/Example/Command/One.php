<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\SendMessage;

class One extends AbstractCommand
{
    public function run()
    {
        $sendMessage = (new SendMessage())
            ->setText('One triggered! args: "'.$this->getArgs().'"');

        $this->reply($sendMessage);
    }
}
