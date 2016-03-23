<?php

namespace Teebot\Entity\Inline;

use Teebot\Entity\AbstractEntity;

abstract class InlineQueryResultAbstract extends AbstractEntity
{
    const PARSE_MODE_MARKDOWN = 'Markdown';

    const PARSE_MODE_HTML     = 'HTML';

    const RESULT_TYPE         = 'InlineQueryResultAbstract';

    protected $id;
    
    protected $title;

    protected $parse_mode;

    protected $disable_web_page_preview;

    protected $thumb_url;

    /**
     * @return string
     */
    public function getType()
    {
        return static::RESULT_TYPE;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return (string) $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return mixed
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
     * @return string
     */
    public function getThumbUrl()
    {
        return (string) $this->thumb_url;
    }

    /**
     * @param string $thumb_url
     *
     * @return $this
     */
    public function setThumbUrl($thumb_url)
    {
        $this->thumb_url = $thumb_url;

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