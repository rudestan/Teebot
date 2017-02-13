<?php

namespace Teebot\Api\Entity\Inline\Result;

class InlineQueryResultDocument extends InlineQueryResultAbstract
{
    const ENTITY_TYPE   = 'InlineQueryResultDocument';

    const RESULT_TYPE   = 'document';

    const MIME_TYPE_PDF = 'application/pdf';

    const MIME_TYPE_ZIP = 'application/zip';

    protected $document_url;

    protected $mime_type;

    protected $description;

    /**
     * @return mixed
     */
    public function getDocumentUrl()
    {
        return $this->document_url;
    }

    /**
     * @param mixed $document_url
     *
     * @return $this
     */
    public function setDocumentUrl($document_url)
    {
        $this->document_url = $document_url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMimeType()
    {
        return $this->mime_type;
    }

    /**
     * @param mixed $mime_type
     *
     * @return $this
     */
    public function setMimeType($mime_type)
    {
        $this->mime_type = $mime_type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}
