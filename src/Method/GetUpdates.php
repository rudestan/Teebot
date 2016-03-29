<?php

/**
 * Class that represents Telegram's Bot-API "getUpdates" method.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

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
     *
     * @return $this
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
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
     *
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
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
     *
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }
}
