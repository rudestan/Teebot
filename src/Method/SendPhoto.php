<?php

namespace Teebot\Method;

class SendPhoto extends AbstractMethod
{
    const NAME          = 'sendPhoto';

    const RETURN_ENTITY = 'Message';

    protected $chatId;

    protected $photo;

    protected $caption;

    protected $disableNotification;

    protected $replyToMessageId;

    protected $replyMarkup;
}
