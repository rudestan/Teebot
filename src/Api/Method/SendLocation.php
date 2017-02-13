<?php

/**
 * Class that represents Telegram's Bot-API "sendLocation" method.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Method;

use Teebot\Api\Entity\Message;

class SendLocation extends AbstractMethod
{
    const NAME          = 'sendLocation';

    const RETURN_ENTITY = Message::class;

    protected $chat_id;

    protected $latitude;

    protected $longitude;

    protected $disable_notification;

    protected $reply_to_message_id;

    protected $reply_markup;

    protected $supportedProperties = [
        'chat_id'              => true,
        'latitude'             => true,
        'longitude'            => true,
        'disable_notification' => false,
        'reply_to_message_id'  => false,
        'reply_markup'         => false
    ];
}
