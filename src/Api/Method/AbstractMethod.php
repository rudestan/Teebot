<?php

/**
 * Base abstract class for supported by Telegram Method classes.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Method;

use Teebot\Api\Traits\Property;
use Teebot\Api\Entity\{
    EntityInterface, Inline\InlineKeyboardMarkup, ReplyKeyboardMarkup, ReplyKeyboardHide, ForceReply
};

abstract class AbstractMethod implements MethodInterface {

    use Property;

    protected const NAME = null;

    protected const RETURN_ENTITY = null;

    protected $parent = null;

    protected $hasAttachedData = false;

    protected $reply_markup;

    /**
     * @var array
     */
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
    public function __construct(array $args = [])
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
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * Returns entity's name that should be return in method execution result.
     *
     * @return null|string
     */
    public function getReturnEntity(): ?string
    {
        return static::RETURN_ENTITY;
    }

    /**
     * Returns flag which indicates that method has attached data (audio, voice, video, photo etc.)
     *
     * @return bool
     */
    public function hasAttachedData(): bool
    {
        return $this->hasAttachedData;
    }

    /**
     * Checks that passed markup is currently supported
     *
     * @param EntityInterface $markup Markup class instance
     *
     * @return bool
     */
    protected function isValidMarkup(EntityInterface $markup): bool
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
     * @param EntityInterface $markup Markup class instance
     *
     * @return MethodInterface
     */
    public function setReplyMarkup(EntityInterface $markup): MethodInterface
    {
        $this->reply_markup = !$this->isValidMarkup($markup) ? null : $markup;

        return $this;
    }

    /**
     * Returns reply markup as JSON encoded string if reply_markup is an instance of EntityInterface
     *
     * @return string|mixed
     */
    public function getReplyMarkup()
    {
        if ($this->reply_markup instanceof EntityInterface) {

            return str_replace('\\\\', '\\', $this->reply_markup->asJson());
        }

        return $this->reply_markup;
    }

    /**
     * Returns parent entity which triggered method's execution.
     *
     * @return MethodInterface
     */
    public function getParent(): MethodInterface
    {
        return $this->parent;
    }

    /**
     * Sets parent entity which triggered method's execution.
     *
     * @param MethodInterface $parent
     *
     * @return MethodInterface
     */
    public function setParent(MethodInterface $parent): MethodInterface
    {
        $this->parent = $parent;

        return $this;
    }
}
