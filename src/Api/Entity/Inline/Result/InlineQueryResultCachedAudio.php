<?php

namespace Teebot\Api\Entity\Inline\Result;

class InlineQueryResultCachedAudio extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultCachedAudio';

    protected $audio_file_id;

    /**
     * @return mixed
     */
    public function getAudioFileId()
    {
        return $this->audio_file_id;
    }

    /**
     * @param mixed $audio_file_id
     *
     * @return $this
     */
    public function setAudioFileId($audio_file_id)
    {
        $this->audio_file_id = $audio_file_id;

        return $this;
    }
}
