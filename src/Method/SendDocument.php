<?php

namespace Teebot\Method;

use Teebot\Entity\Message;
use Teebot\Traits\File;
use Teebot\Entity\InputFile;

class SendDocument extends AbstractMethod
{
    use File;

    const NAME          = 'sendDocument';

    const RETURN_ENTITY = Message::class;

    const FILE_SIZE_LIMIT_MB = 50;

    protected $chat_id;

    protected $document;

    protected $caption;

    protected $disable_notification;

    protected $reply_to_message_id;

    protected $reply_markup;

    protected $supportedProperties = [
        'chat_id'  => true,
        'document' => true,
        'caption'  => false,
        'disable_notification' => false,
        'reply_to_message_id' => false,
        'reply_markup' => false
    ];

    /**
     * @return \CURLFile|string
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param string $document
     *
     * @return $this
     */
    public function setDocument($document)
    {
        $this->document = (new InputFile($document))->getFileForUpload();

        return $this;
    }
}
