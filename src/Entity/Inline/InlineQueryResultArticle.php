<?php

namespace Teebot\Entity\Inline;

use Teebot\Entity\AbstractEntity;

class InlineQueryResultArticle extends AbstractEntity
{
    const ENTITY_TYPE = 'InlineQueryResultArticle';

    protected $type;

    protected $id;

    protected $title;

    protected $message_text;

    protected $parse_mode;

    protected $disable_web_page_preview;

    protected $url;

    protected $hide_url;

    protected $description;

    protected $thumb_url;

    protected $thumb_width;

    protected $thumb_height;
}
