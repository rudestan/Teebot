<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Api\Command\AbstractCommand;
use Teebot\Api\Method\SendMessage;

class Two extends AbstractCommand
{
    public function run()
    {
        $sendMessage = (new SendMessage())
            ->setText('Two triggered! args: "'.$this->getArgs().'"');

        $this->reply($sendMessage);
    }
}
