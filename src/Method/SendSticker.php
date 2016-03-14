<?php

namespace Teebot\Method;

class SendSticker extends AbstractMethod
{
    const NAME          = 'sendSticker';

    const RETURN_ENTITY = 'Message';

    const SUPPORTED_FORMAT = 'webp';

    protected $chatId;

    protected $sticker;

    protected $caption;

    protected $disableNotification;

    protected $replyToMessageId;

    protected $replyMarkup;
}
