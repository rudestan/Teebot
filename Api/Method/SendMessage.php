<?php

namespace Teebot\Api\Method;

class SendMessage extends AbstractMethod
{
    const NAME = 'sendMessage';

    protected $args;

    protected $text;

    protected $chatId;

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
