<?php

/**
 * Class that represents Telegram's Bot-API "sendVoice" method.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Method;

use Teebot\Api\Entity\Message;
use Teebot\Api\Traits\File;
use Teebot\Api\Entity\InputFile;

class SendVoice extends AbstractMethod
{
    use File;

    const NAME          = 'sendVoice';

    const RETURN_ENTITY = Message::class;

    protected $chat_id;

    protected $voice;

    protected $duration;

    protected $disable_notification;

    protected $reply_to_message_id;

    protected $reply_markup;

    protected $supportedProperties = [
        'chat_id'              => true,
        'voice'                => true,
        'duration'             => false,
        'disable_notification' => false,
        'reply_to_message_id'  => false,
        'reply_markup'         => false
    ];

    /**
     * @return \CURLFile|string
     */
    public function getVoice()
    {
        return $this->voice;
    }

    /**
     * @param string $voice
     *
     * @return $this
     */
    public function setVoice($voice)
    {
        $this->voice = $this->initInputFile($voice);

        return $this;
    }
}
