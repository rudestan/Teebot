<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\GetMe;

class Me extends AbstractCommand
{
    public function run()
    {
        $method = new GetMe();

        $this->callRemoteMethod($method);
    }
}
