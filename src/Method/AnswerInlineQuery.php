<?php

namespace Teebot\Method;

class AnswerInlineQuery extends AbstractMethod
{
    const NAME          = 'answerInlineQuery';

    const RETURN_ENTITY = null;

    protected $inline_query_id;

    protected $results;

    protected $cache_time;

    protected $is_personal;

    protected $next_offset;

    protected $supportedProperties = [
        'inline_query_id' => true,
        'results'         => true,
        'cache_time'      => false,
        'is_personal'     => true,
        'next_offset'     => true
    ];

    /**
     * @return mixed
     */
    public function getInlineQueryId()
    {
        return $this->inline_query_id;
    }

    /**
     * @param mixed $inline_query_id
     *
     * @return $this
     */
    public function setInlineQueryId($inline_query_id)
    {
        $this->inline_query_id = $inline_query_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param mixed $results
     *
     * @return $this
     */
    public function setResults($results)
    {
        $this->results = $results;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCacheTime()
    {
        return $this->cache_time;
    }

    /**
     * @param mixed $cache_time
     *
     * @return $this
     */
    public function setCacheTime($cache_time)
    {
        $this->cache_time = $cache_time;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsPersonal()
    {
        return $this->is_personal;
    }

    /**
     * @param mixed $is_personal
     *
     * @return $this
     */
    public function setIsPersonal($is_personal)
    {
        $this->is_personal = $is_personal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNextOffset()
    {
        return $this->next_offset;
    }

    /**
     * @param mixed $next_offset
     *
     * @return $this
     */
    public function setNextOffset($next_offset)
    {
        $this->next_offset = $next_offset;

        return $this;
    }
}
