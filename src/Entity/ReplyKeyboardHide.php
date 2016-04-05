<?php

namespace Teebot\Entity;

class ReplyKeyboardHide extends AbstractEntity {

    protected $hide_keyboard = true;

    protected $selective;

    /**
     * Always sets hide keyboard flag to true
     */
    public function setHideKeyboard()
    {
        $this->hide_keyboard = true;
    }

    /**
     * @return mixed
     */
    public function getSelective()
    {
        return $this->selective;
    }

    /**
     * @param mixed $selective
     *
     * @return $this
     */
    public function setSelective($selective)
    {
        $this->selective = $selective;
        
        return $this;
    }
}
