<?php

namespace Teebot\Entity;

class Audio extends AbstractEntity
{
    const ENTITY_TYPE = 'Audio';

    protected $file_id;

    protected $duration;

    protected $performer;

    protected $title;

    protected $mime_type;

    protected $file_size;
}
