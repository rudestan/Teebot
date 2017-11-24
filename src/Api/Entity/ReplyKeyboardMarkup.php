<?php

namespace Teebot\Api\Entity;

class ReplyKeyboardMarkup extends AbstractEntity
{
    public const ENTITY_TYPE = 'ReplyKeyboardMarkup';

    protected $keyboard;

    protected $resize_keyboard;

    protected $one_time_keyboard;

    protected $selective;

    protected $supportedProperties = [
        'keyboard' => true,
        'resize_keyboard' => false,
        'one_time_keyboard' => false,
        'selective' => false,
    ];

    /**
     * @return array
     */
    public function getKeyboard()
    {
        return $this->keyboard;
    }

    /**
     * @param array $keyboard
     *
     * @return EntityInterface
     */
    public function setKeyboard(array $keyboard): EntityInterface
    {
        $this->keyboard = $keyboard;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResizeKeyboard()
    {
        return $this->resize_keyboard;
    }

    /**
     * @param mixed $resize_keyboard
     *
     * @return EntityInterface
     */
    public function setResizeKeyboard($resize_keyboard): EntityInterface
    {
        $this->resize_keyboard = $resize_keyboard;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOneTimeKeyboard()
    {
        return $this->one_time_keyboard;
    }

    /**
     * @param mixed $one_time_keyboard
     *
     * @return EntityInterface
     */
    public function setOneTimeKeyboard($one_time_keyboard): EntityInterface
    {
        $this->one_time_keyboard = $one_time_keyboard;

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
     * @return EntityInterface
     */
    public function setSelective($selective): EntityInterface
    {
        $this->selective = $selective;

        return $this;
    }

    /**
     * Returns object's properties encoded as JSON string
     *
     * @param bool $validate Flag whether validation for required properties should be applied
     *
     * @return string
     */
    public function asJson(bool $validate = true): string
    {
        $properties = $this->getPropertiesArray($validate);

        if (isset($properties['keyboard']) && !empty($properties['keyboard'])) {
            foreach ($properties['keyboard'] as $i => $row) {
                if (!is_array($row)) {
                    continue;
                }

                /** @var $button AbstractEntity */
                foreach ($row as $j => $button) {
                    $properties['keyboard'][$i][$j] = $button->getPropertiesArray($validate);
                }
            }
        }

        return json_encode($properties);
    }
}
