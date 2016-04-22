<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\SendMessage;

class Two extends AbstractCommand
{
    public function run()
    {
        $sendMessage = (new SendMessage())
            ->setText('Two triggered! args: "'.$this->getArgs().'"');

        $this->reply($sendMessage);
    }
}
