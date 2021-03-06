<?php

namespace Teebot\Api\Entity;

class Message extends AbstractEntity
{
    const ENTITY_TYPE = 'Message';

    const MESSAGE_TYPE_REGEXP_COMMAND = 'RegexpCommand';

    protected $messageType = self::ENTITY_TYPE;

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

    /** @var MessageEntityArray */
    protected $entities;

    /** @var Audio $audio */
    protected $audio;

    /** @var Document $document */
    protected $document;

    /** @var PhotoSizeArray $photo */
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

    protected $pinned_message;

    protected $builtInEntities = [
        'from'     => User::class,
        'chat'     => Chat::class,
        'location' => Location::class,
        'document' => Document::class,
        'sticker'  => Sticker::class,
        'video'    => Video::class,
        'voice'    => Voice::class,
        'contact'  => Contact::class,
        'audio'    => Audio::class,
        'photo'    => PhotoSizeArray::class,
        'entities' => MessageEntityArray::class
    ];

    public function __construct(array $data)
    {
        $data = isset($data['message']) ? $data['message'] : $data;

        parent::__construct($data);
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
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

    /**
     * @return null|string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return array
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * @param array $entities
     */
    public function setEntities($entities)
    {
        if (is_array($entities)) {
            $source = $this->getText();

            $entities = array_map(function($element) use ($source) {
                $element['source'] = $source;

                return $element;
            }, $entities);
        }
        

        $this->entities = $entities;
        $this->setMessageType($entities);
    }

    /**
     * @return Chat
     */
    public function getChat()
    {
        return $this->chat;
    }

    /**
     * @return string
     */
    public function getMessageType()
    {
        return $this->messageType;
    }

    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param Location $location
     */
    protected function setLocation($location)
    {
        $this->location = $location;
        $this->setMessageType($location);
    }

    /**
     * @return Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param Document $document
     */
    public function setDocument($document)
    {
        $this->document = $document;
        $this->setMessageType($document);
    }

    /**
     * @return Sticker
     */
    public function getSticker()
    {
        return $this->sticker;
    }

    /**
     * @param Sticker $sticker
     */
    public function setSticker($sticker)
    {
        $this->sticker = $sticker;
        $this->setMessageType($sticker);
    }

    /**
     * @return Video
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param Video $video
     */
    public function setVideo($video)
    {
        $this->video = $video;
        $this->setMessageType($video);
    }

    /**
     * @return Voice
     */
    public function getVoice()
    {
        return $this->voice;
    }

    /**
     * @param Voice $voice
     */
    public function setVoice($voice)
    {
        $this->voice = $voice;
        $this->setMessageType($voice);
    }

    /**
     * @return Contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param Contact $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
        $this->setMessageType($contact);
    }

    /**
     * @return Audio
     */
    public function getAudio()
    {
        return $this->audio;
    }

    /**
     * @param Audio $audio
     */
    public function setAudio($audio)
    {
        $this->audio = $audio;
        $this->setMessageType($audio);
    }

    /**
     * @return PhotoSizeArray
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param PhotoSizeArray $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
        $this->setMessageType($photo);
    }

    protected function setMessageType($object)
    {
        $this->messageType = static::ENTITY_TYPE;

        if ($object instanceof AbstractEntity) {
            $this->messageType = $object->getEntityType();
        }
    }

    /**
     * @return null|Contact|Document|Location|Sticker|Video|Voice
     */
    public function getMessageTypeEntity()
    {
        $messageTypeEntity = null;

        switch ($this->getMessageType()) {
            case Location::ENTITY_TYPE:
                $messageTypeEntity = $this->location;
                break;
            case Document::ENTITY_TYPE:
                $messageTypeEntity = $this->document;
                break;
            case Sticker::ENTITY_TYPE:
                $messageTypeEntity = $this->sticker;
                break;
            case Video::ENTITY_TYPE:
                $messageTypeEntity = $this->video;
                break;
            case Voice::ENTITY_TYPE:
                $messageTypeEntity = $this->voice;
                break;
            case Contact::ENTITY_TYPE:
                $messageTypeEntity = $this->contact;
                break;
            case Audio::ENTITY_TYPE:
                $messageTypeEntity = $this->audio;
                break;
            case PhotoSizeArray::ENTITY_TYPE:
                $messageTypeEntity = $this->photo;
                break;
            case MessageEntityArray::ENTITY_TYPE:
                $messageTypeEntity = $this->entities;
                break;
        }

        return $messageTypeEntity;
    }

    public function hasBuiltinRegexpCommand($pattern)
    {
        return (bool) preg_match($pattern, $this->getText());
    }
}
