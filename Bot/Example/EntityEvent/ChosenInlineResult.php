<?php

namespace Teebot\Bot\Example\EntityEvent;

use Teebot\Command\AbstractEntityEvent;

class ChosenInlineResult extends AbstractEntityEvent
{
    /** @var \Teebot\Entity\Inline\ChosenInlineResult $entity */
    protected $entity;

    public function run()
    {
        return true;
    }
}
