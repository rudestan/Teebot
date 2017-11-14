<?php

/**
 * Base abstract class for supported by Telegram Method classes.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Method;

use Teebot\Api\Entity\AbstractEntity;
use Teebot\Api\Traits\Property;
use Teebot\Api\Entity\Inline\InlineKeyboardMarkup;
use Teebot\Api\Entity\ReplyKeyboardMarkup;
use Teebot\Api\Entity\ReplyKeyboardHide;
use Teebot\Api\Entity\ForceReply;

abstract class AbstractMethod {

    use Property;

    const NAME            = null;

    const RETURN_ENTITY   = null;

    protected $parent = null;

    protected $hasAttachedData = false;

    protected $reply_markup;

    /**
     * List of properties supported by method in format: property name => required or not
     *
     * @var array
     */
    protected $supportedProperties = [];

    protected $supportedMarkups = [
        InlineKeyboardMarkup::class,
        ReplyKeyboardMarkup::class,
        ReplyKeyboardHide::class,
        ForceReply::class
    ];

    /**
     * Constructs extended method's class and sets properties from array if passed.
     *
     * @param array $args
     */
    public function __construct($args = [])
    {
        if (empty($args)) {
            return;
        }

        $this->setProperties($args);
    }

    /**
     * Returns method's name.
     *
     * @return string
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * Returns entity's name that should be return in method execution result.
     *
     * @return string
     */
    public function getReturnEntity()
    {
        return static::RETURN_ENTITY;
    }

    /**
     * Returns flag which idicates that method has attached data (audio, voice, video, photo etc.)
     *
     * @return bool
     */
    public function hasAttachedData()
    {
        return $this->hasAttachedData;
    }

    /**
     * Checks that passed markup is currently supported
     *
     * @param AbstractEntity $markup Markup class instance
     *
     * @return bool
     */
    protected function isValidMarkup(AbstractEntity $markup)
    {
        foreach ($this->supportedMarkups as $className) {
            if ($markup instanceof $className) {
                return true;
            }
        }

        return false;
    }

    /**
     * Sets reply markup class
     *
     * @param AbstractEntity $markup Markup class instance
     *
     * @return $this
     */
    public function setReplyMarkup(AbstractEntity $markup)
    {
        $this->reply_markup = !$this->isValidMarkup($markup) ? null : $markup;

        return $this;
    }

    /**
     * Returns reply markup as JSON encoded string if reply_markup is an instance of AbstractEntity
     *
     * @return string|mixed
     */
    public function getReplyMarkup()
    {
        if ($this->reply_markup instanceof AbstractEntity) {

            return str_replace('\\\\', '\\', $this->reply_markup->asJson());
        }

        return $this->reply_markup;
    }

    /**
     * Returns parent entity which triggered method's execution.
     *
     * @return AbstractEntity
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Sets parent entity which triggered method's execution.
     *
     * @param AbstractEntity $parent
     *
     * @return $this
     */
    public function setParent(AbstractEntity $parent)
    {
        $this->parent = $parent;

        return $this;
    }
}