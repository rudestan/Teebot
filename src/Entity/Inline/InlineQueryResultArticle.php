<?php

namespace Teebot\Entity\Inline;

class InlineQueryResultArticle extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultArticle';

    const RESULT_TYPE = 'article';

    protected $message_text;

    protected $url;

    protected $hide_url;

    protected $description;

    protected $thumb_width;

    protected $thumb_height;
}
