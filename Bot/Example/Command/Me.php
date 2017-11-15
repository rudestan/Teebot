<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Api\Command\AbstractCommand;

class Me extends AbstractCommand
{
    public function run()
    {
        echo 'Me command triggered!';
    }
}
