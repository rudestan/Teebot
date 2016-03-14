<?php

namespace Teebot\Method;

class SendDocument extends AbstractMethod
{
    const NAME          = 'sendDocument';

    const RETURN_ENTITY = 'Message';

    const FILE_SIZE_LIMIT_MB = 50;

    protected $chatId;

    protected $document;

    protected $caption;

    protected $disableNotification;

    protected $replyToMessageId;

    protected $replyMarkup;
}
