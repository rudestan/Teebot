<?php

namespace Teebot\Bot\Example\EntityEvent;

use Teebot\Command\AbstractEntityEvent;
use Teebot\Method\SendMessage;
use Teebot\Entity\MessageEntityArray;
use Teebot\Entity\MessageEntity;

class EntityArray extends AbstractEntityEvent
{
    public function run()
    {
        return true;
    }
}
