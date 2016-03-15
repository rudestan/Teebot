<?php

namespace Teebot\Entity;

class ReplyKeyboardHide extends AbstractEntity {

    protected $hide_keyboard = true;

    protected $selective;

    /**
     * @param boolean $hide_keyboard
     */
    public function setHideKeyboard($hide_keyboard)
    {
        $this->hide_keyboard = true;
    }
}
