<?php

namespace Teebot\Entity;

class ReplyKeyboardMarkup extends AbstractEntity {

    protected $keyboard = [];

    protected $resize_keyboard;

    protected $one_time_keyboard;

    protected $selective;
}
