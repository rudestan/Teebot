<?php

namespace Teebot\Api\Method;

abstract class AbstractMethod {

    const RETURN_ENTITY = null;

    protected $args;

    abstract public function getName();
    abstract public function getArgs();

    public function getReturnEntityType()
    {
        return static::RETURN_ENTITY;
    }

    public function getArgsAsString()
    {
        $argsString = '';
        $args = $this->getArgs();

        if (!empty($args)) {
            $parts = [];

            foreach ($args as $k => $v) {
                $parts[] = $k . '=' . $v;
            }
            $argsString = implode('&', $parts);
        }

        return $argsString;
    }
}
