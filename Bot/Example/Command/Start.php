<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\SendMessage;
use Teebot\Entity\ReplyKeyboardMarkup;
use Teebot\Entity\KeyboardButton;

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
