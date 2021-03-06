<?php

namespace Teebot\Api\Entity\Inline;

use Teebot\Api\Entity\AbstractEntity;
use Teebot\Api\Entity\Location;
use Teebot\Api\Entity\User;

class InlineQuery extends AbstractEntity
{
    const ENTITY_TYPE = 'InlineQuery';

    protected $id;

    protected $from;

    protected $location;

    protected $query;

    protected $offset;

    protected $builtInEntities = [
        'from'     => User::class,
        'location' => Location::class
    ];

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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

    /**
     * @return mixed
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param mixed $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }
}
