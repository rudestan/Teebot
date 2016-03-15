<?php

namespace Teebot\Method;

use Teebot\Entity\AbstractEntity;
use Teebot\Exception\Critical;
use Teebot\Command\Executor;
use Teebot\Traits\Property;
use Teebot\Entity\ReplyKeyboardMarkup;
use Teebot\Entity\ReplyKeyboardHide;
use Teebot\Entity\ForceReply;

abstract class AbstractMethod {

    use Property;

    const NAME            = null;

    const RETURN_ENTITY   = null;

    protected $hasAttachedData = false;

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

        try {
            $this->validateArgs($args);
        } catch (Critical $e) {
            echo $e->getMessage();

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

    public function send($parent, $silentMode = true)
    {
        $executor = Executor::getInstance();

        return $executor->callRemoteMethod($this, $silentMode, $parent);
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
            echo $e->getMessage();

            $markup = null;
        }
        $this->reply_markup = $markup;

        return $this;
    }
}
