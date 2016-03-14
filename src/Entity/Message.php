<?php

namespace Teebot\Entity;

class Message extends AbstractEntity
{
    const ENTITY_TYPE = 'Message';

    protected $updateId;

    protected $messageId;

    /** @var User $from */
    protected $from;

    protected $date;

    /** @var Chat $chat */
    protected $chat;

    /** @var User $forwardFrom */
    protected $forwardFrom;

    protected $forwardDate;

    /** @var Message $replyToMessage */
    protected $replyToMessage;

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

    /** @var User $newChatParticipant */
    protected $newChatParticipant;

    /** @var User $leftChatParticipant */
    protected $leftChatParticipant;

    protected $newChatTitle;

    /** @var PhotoSize[] $newChatPhoto */
    protected $newChatPhoto;

    protected $deleteChatPhoto;

    protected $groupChatCreated;

    protected $supergroupChatCreated;

    protected $channelChatCreated;

    protected $migrateToChatId;

    protected $migrateFromChatId;

    public function __construct(array $data)
    {
        $this->updateId = $data['update_id'] ?? null;

        if (isset($data['message'])) {
            $message         = $data['message'];
            $message['from'] = isset($message['from']) ? new User($message['from']) : null;
            $message['chat'] = isset($message['chat']) ? new Chat($message['chat']) : null;

            parent::__construct($message);
        }
    }

    /**
     * @return null
     */
    public function getUpdateId()
    {
        return $this->updateId;
    }

    /**
     * @return null
     */
    public function getMessageId()
    {
        return $this->messageId;
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
}
