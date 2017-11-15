<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Api\Command\AbstractCommand;

class Foo extends AbstractCommand
{
    public function run()
    {
        echo 'Foo triggered!';
    }
}
