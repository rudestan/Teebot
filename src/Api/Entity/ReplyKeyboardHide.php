<?php

namespace Teebot\Api\Entity;

class ReplyKeyboardHide extends AbstractEntity {

    protected $hide_keyboard = true;

    protected $selective;

    protected $supportedProperties = [
        'hide_keyboard' => true,
        'selective' => false
    ];

    /**
     * Always sets hide keyboard flag to true
     */
    public function setHideKeyboard()
    {
        $this->hide_keyboard = true;

        return $this;
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
