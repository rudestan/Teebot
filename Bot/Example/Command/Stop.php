<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Api\Command\AbstractCommand;
use Teebot\Api\Method\SendMessage;
use Teebot\Api\Entity\ReplyKeyboardHide;

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
