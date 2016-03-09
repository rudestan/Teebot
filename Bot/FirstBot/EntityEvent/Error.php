<?php

namespace Teebot\Bot\FirstBot\EntityEvent;

use Teebot\Api\Command\AbstractCommand;

class Error extends AbstractCommand
{
    /** @var \Teebot\Api\Entity\Error $entity */
    protected $entity;

    public function run()
    {
        echo sprintf('[%s]: %s', $this->entity->getErrorCode(), $this->entity->getDescription());
    }
}
