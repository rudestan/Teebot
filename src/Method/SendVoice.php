<?php

namespace Teebot\Method;

class SendVoice extends AbstractMethod
{
    const NAME          = 'sendVoice';

    const RETURN_ENTITY = 'Message';

    const FILE_SIZE_LIMIT_MB = 50;

    const SUPPORTED_FORMAT = 'ogg';

    protected $chatId;

    protected $voice;

    protected $duration;

    protected $disableNotification;

    protected $replyToMessageId;

    protected $replyMarkup;
}
