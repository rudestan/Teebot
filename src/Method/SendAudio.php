<?php

namespace Teebot\Method;

use Teebot\Entity\Message;
use Teebot\Traits\File;
use Teebot\Entity\InputFile;

class SendAudio extends AbstractMethod
{
    use File;

    const NAME               = 'sendAudio';

    const RETURN_ENTITY      = Message::class;

    const FILE_SIZE_LIMIT_MB = 50;

    const SUPPORTED_FORMAT   = 'mp3';

    protected $chat_id;

    protected $audio;

    protected $duration;

    protected $performer;

    protected $title;

    protected $disable_notification;

    protected $reply_to_message_id;

    protected $reply_markup;

    protected $supportedProperties = [
        'chat_id'              => true,
        'audio'                => true,
        'duration'             => false,
        'performer'            => false,
        'title'                => false,
        'disable_notification' => false,
        'reply_to_message_id'  => false,
        'reply_markup'         => false
    ];

    /**
     * @return \CURLFile
     */
    public function getAudio()
    {
        return $this->audio;
    }

    /**
     * @param string $photo
     *
     * @return $this
     */
    public function setAudio($audio)
    {
        $inputFile   = new InputFile($audio);
        $this->audio = $inputFile->getFileForUpload();

        return $this;
    }
}
