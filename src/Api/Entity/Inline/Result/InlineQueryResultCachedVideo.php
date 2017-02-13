<?php

namespace Teebot\Api\Entity\Inline\Result;

class InlineQueryResultCachedVideo extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultCachedVideo';

    protected $video_file_id;

    /**
     * @return mixed
     */
    public function getVideoFileId()
    {
        return $this->video_file_id;
    }

    /**
     * @param mixed $video_file_id
     *
     * @return $this
     */
    public function setVideoFileId($video_file_id)
    {
        $this->video_file_id = $video_file_id;

        return $this;
    }
}