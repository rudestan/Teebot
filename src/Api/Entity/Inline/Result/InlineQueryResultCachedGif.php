<?php

namespace Teebot\Api\Entity\Inline\Result;

class InlineQueryResultCachedGif extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultCachedGif';

    protected $gif_file_id;

    /**
     * @return mixed
     */
    public function getGifFileId()
    {
        return $this->gif_file_id;
    }

    /**
     * @param mixed $gif_file_id
     *
     * @return $this
     */
    public function setGifFileId($gif_file_id)
    {
        $this->gif_file_id = $gif_file_id;

        return $this;
    }
}
