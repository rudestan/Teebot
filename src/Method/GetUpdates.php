<?php

namespace Teebot\Method;

class GetUpdates extends AbstractMethod
{
    const NAME = 'getUpdates';

    protected $offset;

    protected $limit   = 1;

    protected $timeout = 3;
}
