<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\SendAudio;

class Audio extends AbstractCommand
{
    public function run()
    {
        $audio = '/var/www/html/audio.mp3';

        $args = [
            'chat_id' => $this->getChatId(),
            'audio'   => $audio
        ];

        $method = new SendAudio($args);
        $method->trigger();
    }
}
