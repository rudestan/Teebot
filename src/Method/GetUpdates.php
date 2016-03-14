<?php

namespace Teebot\Method;

class GetUpdates extends AbstractMethod
{
    const NAME = 'getUpdates';

    protected $offset;

    protected $limit   = 1;

    protected $timeout = 3;

    protected $supportedProperties = [
        'offset'  => false,
        'limit'   => false,
        'timeout' => false
    ];

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

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }
}
