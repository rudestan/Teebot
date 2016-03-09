<?php

namespace Teebot\Method;

class GetMe extends AbstractMethod
{
    const NAME = 'getMe';

    const RETURN_ENTITY = 'User';

    protected $args;

    protected $text;

    protected $chatId;

    public function __construct($args) {}

    public function getName()
    {
        return self::NAME;
    }

    public function getArgs()
    {
        return null;
    }
}
