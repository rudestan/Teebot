<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\SendDocument;

class Document extends AbstractCommand
{
    public function run()
    {
        $document = '/var/www/html/document.pdf';

        $args = [
            'chat_id'  => $this->getChatId(),
            'document' => $document
        ];

        $method = new SendDocument($args);
        $method->trigger();
    }
}
