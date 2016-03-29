<?php

/**
 * Class that represents Telegram's Bot-API "getMe" method.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Method;

use Teebot\Entity\User;

class GetMe extends AbstractMethod
{
    const NAME          = 'getMe';

    const RETURN_ENTITY = User::class;
}
