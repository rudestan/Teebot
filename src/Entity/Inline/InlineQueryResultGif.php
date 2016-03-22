<?php

namespace Teebot\Entity\Inline;

use Teebot\Entity\AbstractEntity;

class InlineQueryResultGif extends AbstractEntity
{
    const ENTITY_TYPE = 'InlineQueryResultGif';

    protected $type;

    protected $id;

    protected $gif_url;

    protected $gif_width;

    protected $gif_height;

    protected $thumb_url;

    protected $title;

    protected $caption;

    protected $message_text;

    protected $parse_mode;

    protected $disable_web_page_preview;
}
