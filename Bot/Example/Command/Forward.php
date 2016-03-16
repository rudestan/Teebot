<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Method\ForwardMessage;

class Forward extends AbstractCommand
{
    public function run()
    {
        $args = [
            'chat_id'      => -139482332,
            'from_chat_id' => 56293731,
            'message_id'   => 579
        ];
        $method = new ForwardMessage($args);
        $method->trigger();
    }
}
