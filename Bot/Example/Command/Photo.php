<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\SendPhoto;

class Photo extends AbstractCommand
{
    public function run()
    {
        $args = [
            'chat_id' => $this->getChatId()
        ];

        $method = new SendPhoto($args);
        $method->send($this->entity);
    }
}
