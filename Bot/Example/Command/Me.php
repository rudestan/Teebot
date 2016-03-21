<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\GetMe;

class Me extends AbstractCommand
{
    public function run()
    {

        var_dump($this->entity);

        echo "Command /me triggered!";
/*        (new GetMe())
            ->setParent($this->entity)
            ->trigger(false);*/
    }
}
