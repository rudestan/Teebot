<?php

namespace Teebot\Method;

class SendMessage extends AbstractMethod
{
    const NAME                = 'sendMessage';

    const RETURN_ENTITY       = 'Message';

    const PARSE_MODE_MARKDOWN = 'Markdown';

    const PARSE_MODE_HTML     = 'HTML';

    protected $chat_id;

    protected $text;

    protected $parse_mode;

    protected $disable_web_page_preview;

    protected $disable_notification;

    protected $reply_to_message_id;

    protected $reply_markup;

    protected $supportedProperties = [
        'chat_id'                  => true,
        'text'                     => true,
        'parse_mode'               => false,
        'disable_web_page_preview' => false,
        'disable_notification'     => false,
        'reply_to_message_id'      => false,
        'reply_markup'             => false,
    ];
}
