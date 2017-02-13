<?php

/**
 * Class that represents Telegram's Bot-API "unbanChatMember" method.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author  Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Method;

class UnbanChatMember extends AbstractMethod
{
    const NAME          = 'unbanChatMember';

    const RETURN_ENTITY = null;

    protected $chat_id;

    protected $user_id;

    protected $supportedProperties = [
        'chat_id' => true,
        'user_id' => true
    ];

    /**
     * @return mixed
     */
    public function getChatId()
    {
        return $this->chat_id;
    }

    /**
     * @param mixed $chat_id
     *
     * @return $this
     */
    public function setChatId($chat_id)
    {
        $this->chat_id = $chat_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     *
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }
}
