<?php

namespace Teebot\Entity;

class Message extends AbstractEntity
{
    const ENTITY_TYPE = 'Message';

    protected $update_id;

    protected $message_id;

    /** @var User $from */
    protected $from;

    protected $date;

    /** @var Chat $chat */
    protected $chat;

    /** @var User $forward_from */
    protected $forward_from;

    protected $forward_date;

    /** @var Message $reply_to_message */
    protected $reply_to_message;

    protected $text;

    /** @var Audio $audio */
    protected $audio;

    /** @var Document $document */
    protected $document;

    /** @var Photo $photo */
    protected $photo;

    /** @var Sticker $sticker */
    protected $sticker;

    /** @var Video $video */
    protected $video;

    /** @var Voice $voice */
    protected $voice;

    protected $caption;

    /** @var Contact $contact */
    protected $contact;

    /** @var Location $location */
    protected $location;

    /** @var User $new_chat_participant */
    protected $new_chat_participant;

    /** @var User $left_chat_participant */
    protected $left_chat_participant;

    protected $new_chat_title;

    /** @var PhotoSize[] $new_chat_photo */
    protected $new_chat_photo;

    protected $delete_chat_photo;

    protected $group_chat_created;

    protected $supergroup_chat_created;

    protected $channel_chat_created;

    protected $migrate_to_chat_id;

    protected $migrate_from_chat_id;

    protected $builtInEntities = [
        'from' => User::class,
        'chat' => Chat::class
    ];

    public function __construct(array $data)
    {
        $this->update_id = $data['update_id'] ?? null;
        $data            = $data['message'] ?? $data;

        $data = $this->initBuiltInEntities($data);

        parent::__construct($data);
    }

    /**
     * @return null
     */
    public function getUpdateId()
    {
        return $this->update_id;
    }

    /**
     * @return null
     */
    public function getMessageId()
    {
        return $this->message_id;
    }

    /**
     * @return User
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return null
     */
    public function getChatId()
    {
        if ($this->chat instanceof Chat) {
            return $this->chat->getId();
        }

        return null;
    }

    /**
     * @return null
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return null
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return Chat
     */
    public function getChat()
    {
        return $this->chat;
    }
}
