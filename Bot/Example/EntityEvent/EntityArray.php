<?php

namespace Teebot\Bot\Example\EntityEvent;

use Teebot\Api\Command\AbstractEntityEvent;

class EntityArray extends AbstractEntityEvent
{
    public function run()
    {
        return true;
    }
}
