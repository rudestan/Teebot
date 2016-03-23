<?php

namespace Teebot\Entity\Inline;

class InlineQueryResultMpeg4Gif extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultMpeg4Gif';

    const RESULT_TYPE = 'mpeg4_gif';

    protected $mpeg4_url;

    protected $mpeg4_width;

    protected $mpeg4_height;

    protected $caption;

    protected $message_text;
}
