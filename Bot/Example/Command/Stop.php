<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\SendMessage;
use Teebot\Entity\ReplyKeyboardHide;

/**
 * @author Stanislav Drozdov <stanislav.drozdov@westwing.de>
 */

class Stop extends AbstractCommand {

    public function run()
    {
        $replyMarkup = (new ReplyKeyboardHide())->setHideKeyboard();     
        
        $msg = (new SendMessage())
            ->setText('Hide!')
            ->setReplyMarkup($replyMarkup);

        $this->reply($msg);
    }
}
