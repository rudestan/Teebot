<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Api\Command\AbstractCommand;
use Teebot\Api\Method\SendMessage;
use Teebot\Api\Entity\ReplyKeyboardMarkup;
use Teebot\Api\Entity\KeyboardButton;

class Start extends AbstractCommand
{
    public function run()
    {
        $sendMessage = (new SendMessage())
            ->setText('Hello! I am Multipurpose bot!')
            ->setReplyMarkup($this->getKeyboard());

        $this->reply($sendMessage);
    }

    protected function getKeyboard()
    {
        $button = (new KeyboardButton())
            ->setText('\ud83d\udcb0 /balance');

        $keyboardMarkup = (new ReplyKeyboardMarkup())
            ->setResizeKeyboard(true)
            ->setKeyboard([
                [$button]
            ]);

        return $keyboardMarkup;
    }

}
