<?php

namespace Teebot\Entity\Inline\Result;

class InlineQueryResultCachedMpeg4Gif extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultCachedMpeg4Gif';

    protected $mpeg4_file_id;

    /**
     * @return mixed
     */
    public function getMpeg4FileId()
    {
        return $this->mpeg4_file_id;
    }

    /**
     * @param mixed $mpeg4_file_id
     *
     * @return $this
     */
    public function setMpeg4FileId($mpeg4_file_id)
    {
        $this->mpeg4_file_id = $mpeg4_file_id;

        return $this;
    }
}