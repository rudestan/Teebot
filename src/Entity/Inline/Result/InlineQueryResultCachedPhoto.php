<?php

namespace Teebot\Entity\Inline\Result;

class InlineQueryResultCachedPhoto extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultCachedPhoto';

    protected $photo_file_id;

    /**
     * @return mixed
     */
    public function getPhotoFileId()
    {
        return $this->photo_file_id;
    }

    /**
     * @param mixed $photo_file_id
     *
     * @return $this
     */
    public function setPhotoFileId($photo_file_id)
    {
        $this->photo_file_id = $photo_file_id;

        return $this;
    }
}
