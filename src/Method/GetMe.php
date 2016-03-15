<?php

namespace Teebot\Method;

use Teebot\Entity\User;

class GetMe extends AbstractMethod
{
    const NAME          = 'getMe';

    const RETURN_ENTITY = User::class;
}
