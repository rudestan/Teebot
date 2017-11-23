<?php

namespace Teebot\Api\Entity;

use Teebot\Api\Entity\Inline\InlineQuery;
use Teebot\Api\Entity\Inline\Result\ChosenInlineResult;

class Update extends AbstractEntity
{
    const ENTITY_TYPE = 'Update';

    protected $updateType = Message::ENTITY_TYPE;

    protected $update_id;

    protected $message;

    protected $edited = false;

    protected $inline_query;

    protected $chosen_inline_result;

    protected $builtInEntities = [
        'message'              => Message::class,
        'inline_query'         => InlineQuery::class,
        'chosen_inline_result' => ChosenInlineResult::class
    ];

    /**
     * @return mixed
     */
    public function getUpdateId()
    {
        return $this->update_id;
    }

    /**
     * @param mixed $update_id
     */
    public function setUpdateId($update_id)
    {
        $this->update_id = $update_id;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
        $this->setUpdateType($message);
    }

    /**
     * @return bool
     */
    public function isEdited()
    {
        return $this->edited;
    }

    /**
     * @param bool $edited
     */
    public function setEdited($edited)
    {
        $this->edited = $edited;
    }

    /**
     * @param mixed $message
     */
    public function setEditedMessage($message)
    {
        $this->setMessage($message);
        $this->setEdited(true);
    }

    /**
     * @return mixed
     */
    public function getInlineQuery()
    {
        return $this->inline_query;
    }

    /**
     * @param mixed $inline_query
     */
    public function setInlineQuery($inline_query)
    {
        $this->inline_query = $inline_query;
        $this->setUpdateType($inline_query);
    }

    /**
     * @return mixed
     */
    public function getChosenInlineResult()
    {
        return $this->chosen_inline_result;
    }

    /**
     * @param mixed $chosen_inline_result
     */
    public function setChosenInlineResult($chosen_inline_result)
    {
        $this->chosen_inline_result = $chosen_inline_result;
        $this->setUpdateType($chosen_inline_result);
    }

    /**
     * @return string
     */
    public function getUpdateType()
    {
        return $this->updateType;
    }

    /**
     * @param AbstractEntity $object
     */
    public function setUpdateType($object)
    {
        $this->updateType = static::ENTITY_TYPE;

        if ($object instanceof AbstractEntity) {
            $this->updateType = $object->getEntityType();
        }
    }

    public function getUpdateTypeEntity()
    {
        $updateTypeEntity = null;

        switch ($this->getUpdateType()) {
            case Message::ENTITY_TYPE:
                $updateTypeEntity = $this->message;
                break;
            case InlineQuery::ENTITY_TYPE:
                $updateTypeEntity = $this->inline_query;
                break;
            case ChosenInlineResult::ENTITY_TYPE:
                $updateTypeEntity = $this->chosen_inline_result;
                break;
        }

        return $updateTypeEntity;
    }
}
