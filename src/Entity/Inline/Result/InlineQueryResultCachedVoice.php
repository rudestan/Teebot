<?php

namespace Teebot\Entity\Inline\Inline\Result;

class InlineQueryResultCachedVoice extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultCachedVoice';

    protected $voice_file_id;

    /**
     * @return mixed
     */
    public function getVoiceFileId()
    {
        return $this->voice_file_id;
    }

    /**
     * @param mixed $voice_file_id
     * 
     * @return $this
     */
    public function setVoiceFileId($voice_file_id)
    {
        $this->voice_file_id = $voice_file_id;
        
        return $this;
    }
}
