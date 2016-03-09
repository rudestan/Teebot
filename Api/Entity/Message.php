<?php

namespace Teebot\Api\Entity;

class Message extends AbstractEntity
{
    const TYPE = 'Message';

    protected $updateId = null;

    protected $id = null;

    protected $fromId = null;

    protected $fromFirstName = null;

    protected $fromLastName = null;

    protected $chatId = null;

    protected $chatFirstName = null;

    protected $chatLastName = null;

    protected $chatType;

    protected $date = null;

    protected $text = null;

    public function __construct(array $data = null)
    {
        $this->updateId = $data['update_id'] ?? null;

        if (isset($data['message'])) {
            parent::__construct($data['message']);
        }
    }

    protected function setProperties(array $data)
    {
        $this->id = $this->getPropertyByPath('message_id', $data);
        $this->fromId = $this->getPropertyByPath('from.id', $data);
        $this->fromFirstName = $this->getPropertyByPath('from.first_name', $data);
        $this->fromLastName = $this->getPropertyByPath('from.last_name', $data);
        $this->chatId = $this->getPropertyByPath('chat.id', $data);
        $this->chatFirstName = $this->getPropertyByPath('chat.first_name', $data);
        $this->chatLastName = $this->getPropertyByPath('chat.last_name', $data);
        $this->chatType = $this->getPropertyByPath('chat.type', $data);
        $this->text = $this->getPropertyByPath('text', $data);
        $this->date = $this->getPropertyByPath('date', $data);
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null
     */
    public function getFromId()
    {
        return $this->fromId;
    }

    /**
     * @return null
     */
    public function getFromFirstName()
    {
        return $this->fromFirstName;
    }

    /**
     * @return null
     */
    public function getFromLastName()
    {
        return $this->fromLastName;
    }

    /**
     * @return null
     */
    public function getChatId()
    {
        return $this->chatId;
    }

    /**
     * @return null
     */
    public function getChatFirstName()
    {
        return $this->chatFirstName;
    }

    /**
     * @return null
     */
    public function getChatLastName()
    {
        return $this->chatLastName;
    }

    /**
     * @return mixed
     */
    public function getChatType()
    {
        return $this->chatType;
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
     * @param null $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @param null $chatId
     */
    public function setChatId($chatId)
    {
        $this->chatId = $chatId;
    }
}
