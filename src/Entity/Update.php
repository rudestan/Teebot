<?php

namespace Teebot\Entity;

use Teebot\Entity\Inline\InlineQuery;
use Teebot\Entity\Inline\ChosenInlineResult;

class Update extends AbstractEntity
{
    const ENTITY_TYPE               = 'Update';

    const TYPE_MESSAGE              = 'Message';

    const TYPE_INLINE_QUERY         = 'InlineQuery';

    const TYPE_CHOSEN_INLINE_RESULT = 'ChosenInlineResult';

    protected $updateType   = Message::ENTITY_TYPE;

    protected $update_id;

    protected $message;

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
     * @return mixed
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
            case static::TYPE_MESSAGE:
                $updateTypeEntity = $this->message;
                break;
            case static::TYPE_INLINE_QUERY:
                $updateTypeEntity = $this->inline_query;
                break;
            case static::TYPE_CHOSEN_INLINE_RESULT:
                $updateTypeEntity = $this->chosen_inline_result;
                break;
        }

        return $updateTypeEntity;
    }
}
