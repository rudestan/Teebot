<?php

namespace Teebot\Api\Entity\Inline;

use Teebot\Api\Entity\AbstractEntity;

class InlineKeyboardButton extends AbstractEntity
{
    const ENTITY_TYPE = 'InlineKeyboardButton';

    /** @var string $text */
    protected $text;

    /** @var string $url */
    protected $url;

    /** @var string $callback_data */
    protected $callback_data;

    /** @var string $switch_inline_query */
    protected $switch_inline_query;

    protected $supportedProperties = [
        'text'                => true,
        'url'                 => false,
        'callback_data'       => false,
        'switch_inline_query' => false
    ];

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getCallbackData()
    {
        return $this->callback_data;
    }

    /**
     * @param string $callback_data
     *
     * @return $this
     */
    public function setCallbackData($callback_data)
    {
        $this->callback_data = $callback_data;

        return $this;
    }

    /**
     * @return string
     */
    public function getSwitchInlineQuery()
    {
        return $this->switch_inline_query;
    }

    /**
     * @param string $switch_inline_query
     *
     * @return $this
     */
    public function setSwitchInlineQuery($switch_inline_query)
    {
        $this->switch_inline_query = $switch_inline_query;

        return $this;
    }
}
