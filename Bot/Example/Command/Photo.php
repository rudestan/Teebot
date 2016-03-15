<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\SendPhoto;

class Photo extends AbstractCommand
{
    public function run()
    {
        $photo = '/var/www/html/test.jpg';

        $args = [
            'chat_id' => $this->getChatId(),
            'photo'   => $photo
        ];

        $method = new SendPhoto($args);
        $method->send($this->entity);
    }
}
