<?php

namespace Teebot\Api\Entity\Inline\Result;

class InlineQueryResultAudio extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultAudio';

    const RESULT_TYPE = 'audio';

    protected $audio_url;

    protected $performer;

    protected $audio_duration;

    /**
     * @return mixed
     */
    public function getAudioUrl()
    {
        return $this->audio_url;
    }

    /**
     * @param mixed $audio_url
     *
     * @return $this
     */
    public function setAudioUrl($audio_url)
    {
        $this->audio_url = $audio_url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPerformer()
    {
        return $this->performer;
    }

    /**
     * @param mixed $performer
     *
     * @return $this
     */
    public function setPerformer($performer)
    {
        $this->performer = $performer;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAudioDuration()
    {
        return $this->audio_duration;
    }

    /**
     * @param mixed $audio_duration
     *
     * @return $this
     */
    public function setAudioDuration($audio_duration)
    {
        $this->audio_duration = $audio_duration;

        return $this;
    }
}
