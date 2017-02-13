<?php

namespace Teebot\Api\Entity\Inline\Input;

class InputTextMessageContent extends InputMessageContentAbstract
{
    const ENTITY_TYPE         = 'InputTextMessageContent';

    const PARSE_MODE_MARKDOWN = 'Markdown';

    const PARSE_MODE_HTML     = 'HTML';

    protected $message_text;

    protected $parse_mode;

    protected $disable_web_page_preview;

    protected $supportedProperties = [
        'message_text'             => true,
        'parse_mode'               => false,
        'disable_web_page_preview' => false,
    ];

    /**
     * @param mixed $message_text
     *
     * @return $this
     */
    public function setMessageText($message_text)
    {
        $this->message_text = $message_text;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParseMode()
    {
        return $this->parse_mode;
    }

    /**
     * @param string $parse_mode
     *
     * @return $this
     */
    public function setParseMode($parse_mode)
    {
        $this->parse_mode = $parse_mode;

        return $this;
    }

    /**
     * @return $this
     */
    public function setParseModeMarkdown()
    {
        $this->parse_mode = self::PARSE_MODE_MARKDOWN;

        return $this;
    }

    /**
     * @return $this
     */
    public function setParseModeHTML()
    {
        $this->parse_mode = self::PARSE_MODE_HTML;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDisableWebPagePreview()
    {
        return $this->disable_web_page_preview;
    }

    /**
     * @param mixed $disable_web_page_preview
     *
     * @return $this
     */
    public function setDisableWebPagePreview($disable_web_page_preview)
    {
        $this->disable_web_page_preview = $disable_web_page_preview;

        return $this;
    }
}
