<?php

namespace Teebot\Entity;

class Voice extends AbstractEntity
{
    const ENTITY_TYPE = 'Voice';

    protected $file_id;

    protected $duration;

    protected $mime_type;

    protected $file_size;
}
