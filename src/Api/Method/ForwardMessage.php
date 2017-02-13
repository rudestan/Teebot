<?php

/**
 * Class that represents Telegram's Bot-API "forwardMessage" method.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Method;

use Teebot\Api\Entity\Message;

class ForwardMessage extends AbstractMethod
{
    const NAME          = 'forwardMessage';

    const RETURN_ENTITY = Message::class;

    protected $chat_id;

    protected $from_chat_id;

    protected $disable_notification;

    protected $message_id;

    protected $supportedProperties = [
        'chat_id'              => true,
        'from_chat_id'         => true,
        'disable_notification' => false,
        'message_id'           => true
    ];
}
