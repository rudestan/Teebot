<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\SendVoice;

class Voice extends AbstractCommand
{
    public function run()
    {
        $voice = '/var/www/html/voice.ogg';

        $args = [
            'chat_id' => $this->getChatId(),
            'voice'   => $voice
        ];

        $method = new SendVoice($args);
        $method->trigger();
    }
}
