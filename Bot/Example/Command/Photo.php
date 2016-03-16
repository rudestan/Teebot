<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\SendPhoto;
use Teebot\Method\SendChatAction;

class Photo extends AbstractCommand
{
    public function run()
    {
        (new SendChatAction())
            ->setChatId($this->getChatId())
            ->setAction(SendChatAction::ACTION_UPLOAD_PHOTO)
            ->trigger();

        sleep(2);

        $photo = '/var/www/html/photo.jpg';

        $args = [
            'chat_id' => $this->getChatId(),
            'photo'   => $photo
        ];

        $method = new SendPhoto($args);
        $method->trigger();
    }
}
