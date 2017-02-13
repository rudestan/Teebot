<?php

/**
 * Class that represents Telegram's Bot-API "sendVideo" method.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Method;

use Teebot\Api\Entity\Message;
use Teebot\Api\Entity\InputFile;
use Teebot\Api\Traits\File;

class SendVideo extends AbstractMethod
{
    use File;

    const NAME          = 'sendVideo';

    const RETURN_ENTITY = Message::class;

    protected $chat_id;

    protected $video;

    protected $duration;

    protected $width;

    protected $height;

    protected $caption;

    protected $disable_notification;

    protected $reply_to_message_id;

    protected $reply_markup;

    protected $supportedProperties = [
        'chat_id'              => true,
        'video'                => true,
        'duration'             => false,
        'width'                => false,
        'height'               => false,
        'caption'              => false,
        'disable_notification' => false,
        'reply_to_message_id'  => false,
        'reply_markup'         => false
    ];

    /**
     * @return \CURLFile|string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param string $video
     *
     * @return $this
     */
    public function setVideo($video)
    {
        $this->video = $this->initInputFile($video);

        return $this;
    }
}
