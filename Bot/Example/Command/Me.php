<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Api\Command\AbstractCommand;
use Teebot\Api\Method\SendDocument;
use Teebot\Api\Method\SendMessage;
use Teebot\Api\Method\SendPhoto;

class Me extends AbstractCommand
{
    public function run()
    {
        //$msg = (new SendMessage())->setText('Me triggered!');
        //$msg = (new SendPhoto())->setPhoto(ROOT . '/test.png');

        //$msg = (new SendMessage())->setText('Ping success!');

        //$this->reply($msg);

        $msg = (new SendMessage())
            ->setText('Ping success!');

        $this->reply($msg);
        //$this->processor->callRemoteMethod($msg);

        echo 'YAY!';
    }
}
