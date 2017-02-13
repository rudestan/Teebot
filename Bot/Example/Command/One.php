<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Api\Command\AbstractCommand;
use Teebot\Api\Method\SendMessage;

class One extends AbstractCommand
{
    public function run()
    {
        $sendMessage = (new SendMessage())
            ->setText('One triggered! args: "'.$this->getArgs().'"');

        $this->reply($sendMessage);
    }
}
