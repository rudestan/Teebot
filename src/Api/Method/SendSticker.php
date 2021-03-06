<?php

/**
 * Class that represents Telegram's Bot-API "sendSticker" method.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Method;

use Teebot\Api\Entity\Message;
use Teebot\Api\Traits\File;
use Teebot\Api\Entity\InputFile;

class SendSticker extends AbstractMethod
{
    use File;

    const NAME          = 'sendSticker';

    const RETURN_ENTITY = Message::class;

    protected $chat_id;

    protected $sticker;

    protected $caption;

    protected $disable_notification;

    protected $reply_to_message_id;

    protected $reply_markup;

    protected $supportedProperties = [
        'chat_id' => true,
        'sticker' => true,
        'caption' => false,
        'disable_notification' => false,
        'reply_to_message_id'  => false,
        'reply_markup'         => false
    ];

    /**
     * @return mixed
     */
    public function getSticker()
    {
        return $this->sticker;
    }

    /**
     * @param mixed $sticker
     *
     * @return $this
     */
    public function setSticker($sticker)
    {
        $this->sticker = $this->initInputFile($sticker);

        return $this;

    }


}
