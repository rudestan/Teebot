<?php

/**
 * Class that represents Telegram's Bot-API "sendChatAction" method.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Method;

use Teebot\Api\Entity\Message;

class SendChatAction extends AbstractMethod
{
    const NAME                   = 'sendChatAction';

    const RETURN_ENTITY          = Message::class;

    const ACTION_TYPING          = 'typing';

    const ACTION_UPLOAD_PHOTO    = 'upload_photo';

    const ACTION_RECORD_VIDEO    = 'record_video';

    const ACTION_UPLOAD_VIDEO    = 'upload_video';

    const ACTION_RECORD_AUDIO    = 'record_audio';

    const ACTION_UPLOAD_AUDIO    = 'upload_audio';

    const ACTION_UPLOAD_DOCUMENT = 'upload_document';

    const ACTION_FIND_LOCATION   = 'find_location';

    protected $chat_id;

    protected $action;

    protected $supportedProperties = [
        'chat_id' => true,
        'action'  => true
    ];

    /**
     * @return string
     */
    public function getChatId()
    {
        return $this->chat_id;
    }

    /**
     * @param string $chat_id
     *
     * @return $this
     */
    public function setChatId($chat_id)
    {
        $this->chat_id = $chat_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     *
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }
}
