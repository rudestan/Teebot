<?php

/**
 * Class that represents Telegram's Bot-API "answerInlineQuery" method.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Method;

use Teebot\Api\Entity\Inline\InlineQueryResultArray;

class AnswerInlineQuery extends AbstractMethod
{
    const NAME          = 'answerInlineQuery';

    const RETURN_ENTITY = null;

    protected $inline_query_id;

    /** @var InlineQueryResultArray */
    protected $results;

    protected $cache_time;

    protected $is_personal;

    protected $next_offset;

    protected $switch_pm_text;

    protected $switch_pm_parameter;

    protected $supportedProperties = [
        'inline_query_id'     => true,
        'results'             => true,
        'cache_time'          => false,
        'is_personal'         => false,
        'next_offset'         => false,
        'switch_pm_text'      => false,
        'switch_pm_parameter' => false
    ];

    /**
     * Returns the id of query.
     *
     * @return string
     */
    public function getInlineQueryId()
    {
        return $this->inline_query_id;
    }

    /**
     * Sets inline query id.
     *
     * @param string $inline_query_id
     *
     * @return $this
     */
    public function setInlineQueryId($inline_query_id)
    {
        $this->inline_query_id = $inline_query_id;

        return $this;
    }

    /**
     * Returns result.
     *
     * @return mixed
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Sets result
     *
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
     * Returns cache time.
     *
     * @return mixed
     */
    public function getCacheTime()
    {
        return $this->cache_time;
    }

    /**
     * Sets cache time.
     *
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
     * Returns is personal flag.
     *
     * @return mixed
     */
    public function getIsPersonal()
    {
        return $this->is_personal;
    }

    /**
     * Sets is personal flag
     *
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
     * Returns next offset.
     *
     * @return mixed
     */
    public function getNextOffset()
    {
        return $this->next_offset;
    }

    /**
     * Sets next offset.
     *
     * @param mixed $next_offset
     *
     * @return $this
     */
    public function setNextOffset($next_offset)
    {
        $this->next_offset = $next_offset;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSwitchPmText()
    {
        return $this->switch_pm_text;
    }

    /**
     * @param mixed $switch_pm_text
     *
     * @return $this
     */
    public function setSwitchPmText($switch_pm_text)
    {
        $this->switch_pm_text = $switch_pm_text;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSwitchPmParameter()
    {
        return $this->switch_pm_parameter;
    }

    /**
     * @param mixed $switch_pm_parameter
     *
     * @return $this
     */
    public function setSwitchPmParameter($switch_pm_parameter)
    {
        $this->switch_pm_parameter = $switch_pm_parameter;

        return $this;
    }
}
