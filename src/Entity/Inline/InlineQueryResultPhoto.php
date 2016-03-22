<?php

namespace Teebot\Entity\Inline;

use Teebot\Entity\AbstractEntity;

class InlineQueryResultPhoto extends AbstractEntity
{
    const ENTITY_TYPE = 'InlineQueryResultPhoto';

    protected $type;

    protected $id;

    protected $photo_url;

    protected $photo_width;

    protected $photo_height;

    protected $thumb_url;

    protected $title;

    protected $description;

    protected $caption;

    protected $message_text;

    protected $parse_mode;

    protected $disable_web_page_preview;
}
