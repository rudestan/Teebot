<?php

namespace Teebot\Method;

class SendVideo extends AbstractMethod
{
    const NAME          = 'sendVideo';

    const RETURN_ENTITY = 'Message';

    const FILE_SIZE_LIMIT_MB = 50;

    const SUPPORTED_FORMAT = 'mp4';

    protected $chatId;

    protected $video;

    protected $duration;

    protected $width;

    protected $height;

    protected $caption;

    protected $disableNotification;

    protected $replyToMessageId;

    protected $replyMarkup;
}
