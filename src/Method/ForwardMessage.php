<?php

namespace Teebot\Method;

use Teebot\Entity\Message;

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
