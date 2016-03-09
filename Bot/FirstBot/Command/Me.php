<?php

namespace Teebot\Bot\FirstBot\Command;

use Teebot\Api\Command\AbstractCommand;
use Teebot\Api\Method\GetMe;

class Me extends AbstractCommand
{
    public function run()
    {
        $methodName = GetMe::NAME;

        $this->callRemoteMethod($methodName);
    }
}
