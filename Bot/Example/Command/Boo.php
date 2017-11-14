<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Api\Command\AbstractCommand;

class Boo extends AbstractCommand
{
    public function run()
    {
        echo 'YAY!!!';
    }
}