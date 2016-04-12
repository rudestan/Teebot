<?php

namespace Teebot\Entity\Inline;

use Teebot\Entity\AbstractEntity;

class InlineKeyboardMarkup extends AbstractEntity
{
    const ENTITY_TYPE = 'InlineKeyboardMarkup';

    /** @var array $inline_keyboard */
    protected $inline_keyboard = [];

    protected $supportedProperties = [
        'inline_keyboard' => true
    ];

    /**
     * @return array
     */
    public function getInlineKeyboard()
    {
        return $this->inline_keyboard;
    }

    /**
     * @param array $inline_keyboard
     * 
     * @return $this
     */
    public function setInlineKeyboard($inline_keyboard)
    {
        $this->inline_keyboard = $inline_keyboard;

        return $this;
    }
}
