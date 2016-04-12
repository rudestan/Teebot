<?php

namespace Teebot\Entity\Inline\Result;

use Teebot\Entity\AbstractEntity;
use Teebot\Entity\Location;
use Teebot\Entity\User;

class ChosenInlineResult extends AbstractEntity
{
    const ENTITY_TYPE = 'ChosenInlineResult';

    protected $result_id;

    protected $from;

    protected $location;

    protected $inline_message_id;

    protected $query;

    protected $builtInEntities = [
        'from'     => User::class,
        'location' => Location::class
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
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     *
     * @return $this
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInlineMessageId()
    {
        return $this->inline_message_id;
    }

    /**
     * @param mixed $inline_message_id
     *
     * @return $this
     */
    public function setInlineMessageId($inline_message_id)
    {
        $this->inline_message_id = $inline_message_id;

        return $this;
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
