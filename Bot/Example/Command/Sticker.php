<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\SendSticker;

class Sticker extends AbstractCommand
{
    public function run()
    {
        $sticker = '/var/www/html/sticker.webp';

        $args = [
            'chat_id' => $this->getChatId(),
            'sticker' => $sticker
        ];

        $method = new SendSticker($args);
        $method->trigger();
    }
}
