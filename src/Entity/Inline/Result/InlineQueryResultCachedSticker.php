<?php

namespace Teebot\Entity\Inline\Result;

class InlineQueryResultCachedSticker extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultCachedSticker';

    protected $sticker_file_id;

    /**
     * @return mixed
     */
    public function getStickerFileId()
    {
        return $this->sticker_file_id;
    }

    /**
     * @param mixed $sticker_file_id
     *
     * @return $this
     */
    public function setStickerFileId($sticker_file_id)
    {
        $this->sticker_file_id = $sticker_file_id;

        return $this;
    }
}
