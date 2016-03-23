<?php

namespace Teebot\Method;

use Teebot\Entity\AbstractEntity;
use Teebot\Exception\Critical;
use Teebot\Command\Executor;
use Teebot\Exception\Output;
use Teebot\Traits\Property;
use Teebot\Entity\ReplyKeyboardMarkup;
use Teebot\Entity\ReplyKeyboardHide;
use Teebot\Entity\ForceReply;

abstract class AbstractMethod {

    use Property;

    const NAME            = null;

    const RETURN_ENTITY   = null;

    protected $parent              = null;

    protected $hasAttachedData     = false;

    protected $supportedProperties = [];

    protected $supportedMarkups = [
        ReplyKeyboardMarkup::class,
        ReplyKeyboardHide::class,
        ForceReply::class
    ];

    public function __construct($args = [])
    {
        if (empty($args)) {
            return;
        }

        $this->setProperties($args);
    }

    public function getName()
    {
        return static::NAME;
    }

    public function getReturnEntity()
    {
        return static::RETURN_ENTITY;
    }

    public function trigger($silentMode = true)
    {
        $executor = Executor::getInstance();

        return $executor->callRemoteMethod($this, $silentMode, $this->parent);
    }

    public function hasAttachedData()
    {
        return $this->hasAttachedData;
    }

    protected function isValidMarkup(AbstractEntity $markup)
    {
        foreach ($this->supportedMarkups as $className) {
            if ($markup instanceof $className) {
                return true;
            }
        }

        return false;
    }

    public function setReplyMarkup(AbstractEntity $markup)
    {
        try {
            $isValidMarkup = $this->isValidMarkup($markup);

            if (!$isValidMarkup) {
                throw new Critical("Markup is not supported!");
            }
        } catch (Critical $e) {
            Output::log($e);

            $markup = null;
        }

        $this->reply_markup = $markup;

        return $this;
    }

    /**
     * @return AbstractEntity
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param AbstractEntity $parent
     *
     * @return $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }
}
