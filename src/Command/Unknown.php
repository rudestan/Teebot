<?php

namespace Teebot\Command;

class Unknown extends AbstractCommand
{
    public function run()
    {
        $text = sprintf(
            'Unknown command "%s"!',
            $this->entity->getText()
        );

        $this->sendMessage($text);
    }
}
