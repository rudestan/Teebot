<?php

namespace Teebot\Method;

class SendLocation extends AbstractMethod
{
    const NAME          = 'sendLocation';

    const RETURN_ENTITY = 'Message';

    protected $chatId;

    protected $latitude;

    protected $longitude;

    protected $disableNotification;

    protected $replyToMessageId;

    protected $replyMarkup;
}
