<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Api\Command\AbstractCommand;
use Teebot\Api\Method\SendDocument;
use Teebot\Api\Method\SendMessage;
use Teebot\Api\Method\SendPhoto;

class AutoTriggeredMe extends AbstractCommand
{
    public function run()
    {
        $msg = (new SendMessage())
            ->setText('Ping success!');

        $this->reply($msg);
    }
}
