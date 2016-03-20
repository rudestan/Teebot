<?php

namespace Teebot\Entity;

class Update extends AbstractEntity
{

    const ENTITY_TYPE = 'Update';

    const TYPE_MESSAGE = 'Message';

    const TYPE_INLINE_QUERY = 'InlineQuery';

    const TYPE_CHOSE_INLINE_RESULT = 'ChosenInlineResult';

    protected $updateType = null;

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
    }
}
