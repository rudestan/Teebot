<?php

namespace Teebot\Bot\Example\EntityEvent;

use Teebot\Command\AbstractCommand;

class Error extends AbstractCommand
{
    /** @var \Teebot\Entity\Error $entity */
    protected $entity;

    public function run()
    {
        echo sprintf('[%s]: %s', $this->entity->getErrorCode(), $this->entity->getDescription());
    }
}
