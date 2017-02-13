<?php

/**
 * Class that represents Telegram's Bot-API "getMe" method.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Method;

use Teebot\Api\Entity\User;

class GetMe extends AbstractMethod
{
    const NAME          = 'getMe';

    const RETURN_ENTITY = User::class;
}
