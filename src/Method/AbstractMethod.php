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

    public function getPropertiesAsString()
    {
        $properties = $this->getPropertiesAsArray();

        return $properties ? http_build_query($properties) : '';
    }

    public function getPropertiesAsArray()
    {
        $properties = [];

        foreach ($this->supportedProperties as $name => $isRequired) {

            $getterMethod = $this->getSetGetMethodName("get", $name);

            if ($getterMethod) {
                $properties[$name] = $this->{$getterMethod}();

                continue;
            }

            if (property_exists($this, $name)) {
                $properties[$name] = $this->{$name};
            }
        }

        try {
            $this->validateArgs($properties);
        } catch (Critical $e) {
            Output::log($e);

            $properties = [];
        }

        return $properties;
    }

    protected function validateArgs($args)
    {
        foreach ($this->supportedProperties as $property => $isRequired) {
            if ($isRequired === true && empty($args[$property])) {
                throw new Critical('Required property "'.$property.'" is not set!');
            }
        }
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
