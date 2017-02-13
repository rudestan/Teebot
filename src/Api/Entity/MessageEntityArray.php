<?php

namespace Teebot\Api\Entity;

use Teebot\Api\Entity\MessageEntity;

class MessageEntityArray extends AbstractEntity
{
    const ENTITY_TYPE      = 'MessageEntityArray';

    protected $entities;

    protected $supportedTypes = [
        MessageEntity::TYPE_BOLD,
        MessageEntity::TYPE_BOT_COMMAND,
        MessageEntity::TYPE_CODE,
        MessageEntity::TYPE_EMAIL,
        MessageEntity::TYPE_HASHTAG,
        MessageEntity::TYPE_ITALIC,
        MessageEntity::TYPE_MENTION,
        MessageEntity::TYPE_PRE,
        MessageEntity::TYPE_TEXT_LINK,
        MessageEntity::TYPE_URL
    ];

    public function __construct(array $data)
    {
        if (empty($data)) {
            return;
        }

        $this->setEntities($data);

        parent::__construct($data);
    }

    /**
     * @return mixed
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * @param mixed $entities
     */
    public function setEntities(array $entities)
    {
        $this->entities = $entities;

        if (!empty($entities)) {
            $this->entities = [];

            $previous = null;

            foreach ($entities as $entity) {
                $messageEntity = new MessageEntity($entity);

                if ($previous instanceof MessageEntity) {
                    $previous->setNext($messageEntity);
                }

                $previous = $messageEntity;

                $this->entities[] = $messageEntity;
            }
        }
    }

    public function getEntitiesByType($type)
    {
        $entities = [];

        if (!in_array($type, $this->supportedTypes)) {
            return $entities;
        }

        foreach ($this->entities as $entity) {

            /** @var MessageEntity $entity */
            if ($entity->getType() === $type) {
                $entities[] = $entity;
            }
        }

        return $entities;
    }
}
