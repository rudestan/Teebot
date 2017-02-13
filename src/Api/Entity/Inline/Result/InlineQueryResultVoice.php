<?php

namespace Teebot\Api\Entity\Inline\Result;

class InlineQueryResultVoice extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultVoice';

    const RESULT_TYPE = 'voice';

    protected $voice_url;

    protected $voice_duration;

    /**
     * @return mixed
     */
    public function getVoiceUrl()
    {
        return $this->voice_url;
    }

    /**
     * @param mixed $voice_url
     *
     * @return $this
     */
    public function setVoiceUrl($voice_url)
    {
        $this->voice_url = $voice_url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVoiceDuration()
    {
        return $this->voice_duration;
    }

    /**
     * @param mixed $voice_duration
     *
     * @return $this
     */
    public function setVoiceDuration($voice_duration)
    {
        $this->voice_duration = $voice_duration;

        return $this;
    }
}
