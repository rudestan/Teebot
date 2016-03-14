<?php

namespace Teebot\Method;

class ForwardMessage extends AbstractMethod
{
    const NAME          = 'frowardMessage';

    const RETURN_ENTITY = 'Message';

    protected $chatId;

    protected $fromChatId;

    protected $disableNotification;

    protected $messageId;
}
