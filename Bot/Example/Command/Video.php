<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\SendVideo;

class Video extends AbstractCommand
{
    public function run()
    {
        $video = '/var/www/html/video.mp4';

        $args = [
            'chat_id' => $this->getChatId(),
            'video'  => $video
        ];

        $method = new SendVideo($args);
        $method->trigger();
    }
}
