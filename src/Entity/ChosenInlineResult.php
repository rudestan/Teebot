<?php

namespace Teebot\Entity;

class ChosenInlineResult extends AbstractEntity
{
    const ENTITY_TYPE = 'ChosenInlineResult';

    protected $result_id;

    protected $from;

    protected $query;

    protected $builtInEntities = [
        'from' => User::class
    ];

    /**
     * @return mixed
     */
    public function getResultId()
    {
        return $this->result_id;
    }

    /**
     * @param mixed $result_id
     */
    public function setResultId($result_id)
    {
        $this->result_id = $result_id;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }
}