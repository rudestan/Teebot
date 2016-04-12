<?php

namespace Teebot\Entity\Inline\Result;

use Teebot\Entity\AbstractEntity;
use Teebot\Entity\Inline\Input\InputMessageContentAbstract;

abstract class InlineQueryResultAbstract extends AbstractEntity
{
    const RESULT_TYPE = 'InlineQueryResultAbstract';

    protected $id;

    protected $title;

    protected $reply_markup;
    
    protected $input_message_content;

    protected $thumb_url;

    protected $builtInEntities = [
        'reply_markup'          => InlineKeyboardMarkup::class,
        'input_message_content' => InputMessageContentAbstract::class
    ];

    /**
     * @return string
     */
    public function getType()
    {
        return static::RESULT_TYPE;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return (string) $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return mixed
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInputMessageContent()
    {
        return $this->input_message_content;
    }

    /**
     * @param mixed $input_message_content
     *
     * @return $this
     */
    public function setInputMessageContent(InputMessageContentAbstract $input_message_content)
    {
        $this->input_message_content = $input_message_content;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReplyMarkup()
    {
        return $this->reply_markup;
    }

    /**
     * @param mixed $reply_markup
     *
     * @return $this
     */
    public function setReplyMarkup($reply_markup)
    {
        $this->reply_markup = $reply_markup;

        return $this;
    }

    /**
     * @return string
     */
    public function getThumbUrl()
    {
        return (string) $this->thumb_url;
    }

    /**
     * @param string $thumb_url
     *
     * @return $this
     */
    public function setThumbUrl($thumb_url)
    {
        $this->thumb_url = $thumb_url;

        return $this;
    }
}