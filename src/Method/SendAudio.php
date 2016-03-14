<?php

namespace Teebot\Method;

class SendAudio extends AbstractMethod
{
    const NAME          = 'sendAudio';

    const RETURN_ENTITY = 'Message';

    const FILE_SIZE_LIMIT_MB = 50;

    const SUPPORTED_FORMAT = 'mp3';

    protected $chatId;

    protected $audio;

    protected $duration;

    protected $performer;

    protected $title;

    protected $disableNotification;

    protected $replyToMessageId;

    protected $replyMarkup;
}
