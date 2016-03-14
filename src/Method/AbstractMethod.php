<?php

namespace Teebot\Method;

abstract class AbstractMethod {

    const NAME          = null;

    const RETURN_ENTITY = null;

    protected $args;

    public function __construct($args)
    {
        $this->args = $args;
    }

    public function getName()
    {
        return static::NAME;
    }

    public function getReturnEntityType()
    {
        return static::RETURN_ENTITY;
    }

    public function getArgsAsString()
    {
        $args = $this->getArgs();

        return $args ? http_build_query($args) : '';
    }

    public function getArgs()
    {
        return $this->args;
    }
}
