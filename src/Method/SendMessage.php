<?php

namespace Teebot\Method;

class SendMessage extends AbstractMethod
{
    const NAME                = 'sendMessage';

    const RETURN_ENTITY       = 'Message';

    const PARSE_MODE_MARKDOWN = 'Markdown';

    const PARSE_MODE_HTML     = 'HTML';

    protected $chatId;

    protected $text;

    protected $parseMode;

    protected $disableWebPagePreview;

    protected $disableNotification;

    protected $replyToMessageId;

    protected $replyMarkup;
}
