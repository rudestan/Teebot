<?php

namespace Teebot\Entity\Inline;

class InlineQueryResultVideo extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultVideo';

    const RESULT_TYPE = 'video';

    protected $video_url;

    protected $mime_type;

    protected $message_text;

    protected $video_width;

    protected $video_height;

    protected $video_duration;

    protected $description;
}
