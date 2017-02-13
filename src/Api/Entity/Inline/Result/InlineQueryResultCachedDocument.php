<?php

namespace Teebot\Api\Entity\Inline\Result;

class InlineQueryResultCachedDocument extends InlineQueryResultAbstract
{
    const ENTITY_TYPE = 'InlineQueryResultCachedDocument';

    protected $document_file_id;

    /**
     * @return mixed
     */
    public function getDocumentFileId()
    {
        return $this->document_file_id;
    }

    /**
     * @param mixed $document_file_id
     *
     * @return $this
     */
    public function setDocumentFileId($document_file_id)
    {
        $this->document_file_id = $document_file_id;

        return $this;
    }
}