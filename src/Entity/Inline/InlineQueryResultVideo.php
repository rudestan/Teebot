<?php

namespace Teebot\Entity\Inline;

use Teebot\Entity\AbstractEntity;

class InlineQueryResultVideo extends AbstractEntity
{
    const ENTITY_TYPE = 'InlineQueryResultVideo';

    protected $type;

    protected $id;

    protected $video_url;

    protected $mime_type;

    protected $message_text;

    protected $parse_mode;

    protected $disable_web_page_preview;

    protected $video_width;

    protected $video_height;

    protected $video_duration;

    protected $thumb_url;

    protected $title;

    protected $description;
}
