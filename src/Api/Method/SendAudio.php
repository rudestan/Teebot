<?php

/**
 * Class that represents Telegram's Bot-API "getUserProfilePhotos" method.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Method;

use Teebot\Api\Entity\Message;
use Teebot\Api\Traits\File;
use Teebot\Api\Entity\InputFile;

class SendAudio extends AbstractMethod
{
    use File;

    const NAME               = 'sendAudio';

    const RETURN_ENTITY      = Message::class;

    const FILE_SIZE_LIMIT_MB = 50;

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
     * @return \CURLFile|string
     */
    public function getAudio()
    {
        return $this->audio;
    }

    /**
     * @param string $audio
     *
     * @return $this
     */
    public function setAudio($audio)
    {
        $this->audio = $this->initInputFile($audio);

        return $this;
    }
}
