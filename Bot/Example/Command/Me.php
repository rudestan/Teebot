<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\GetMe;

class Me extends AbstractCommand
{
    public function run()
    {
        $methodName = GetMe::NAME;

        $this->callRemoteMethod($methodName);
    }
}
