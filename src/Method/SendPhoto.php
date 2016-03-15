<?php

namespace Teebot\Method;

use Teebot\Entity\Message;

class SendPhoto extends AbstractMethod
{
    const NAME          = 'sendPhoto';

    const RETURN_ENTITY = Message::class;

    const HAS_BINARY_DATA = true;

    protected $chat_id;

    protected $photo;

    protected $caption;

    protected $disable_notification;

    protected $reply_to_message_id;

    protected $reply_markup;

    protected $supportedProperties = [
        'chat_id'              => true,
        //'photo'                => true,
        'caption'              => false,
        'disable_notification' => false,
        'reply_to_message_id'  => false,
        'reply_markup'         => false
    ];
}
