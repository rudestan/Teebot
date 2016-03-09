<?php

namespace Teebot\Api\Method;

class GetUpdates extends AbstractMethod
{
    const NAME = 'getUpdates';

    protected $args;

    public function __construct($args)
    {
        $this->args = $args;
    }

    public function getName()
    {
        return self::NAME;
    }

    public function getArgs()
    {
        return $this->args;
    }
}
