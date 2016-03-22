<?php

namespace Teebot\Entity\Inline;

use Teebot\Entity\AbstractEntity;

class InlineQueryResultMpeg4Gif extends AbstractEntity
{
    const ENTITY_TYPE = 'InlineQueryResultMpeg4Gif';

    protected $type;

    protected $id;

    protected $mpeg4_url;

    protected $mpeg4_width;

    protected $mpeg4_height;

    protected $thumb_url;

    protected $title;

    protected $caption;

    protected $message_text;

    protected $parse_mode;

    protected $disable_web_page_preview;
}
