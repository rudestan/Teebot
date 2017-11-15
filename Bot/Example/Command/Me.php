<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Api\Command\AbstractCommand;
use Teebot\Api\Method\SendMessage;

class Me extends AbstractCommand
{
    public function run()
    {
        //$msg = (new SendMessage())->setText('Me triggered!');

        //$msg = (new SendMessage())->setText('Ping success!');

        //$this->reply($msg);

        $msg = (new SendMessage())
            ->setText('Ping success!');

        $this->reply($msg);
    }
}
