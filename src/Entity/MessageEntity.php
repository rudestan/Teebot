<?php

namespace Teebot\Entity;

use Teebot\Command\Handler;
use Teebot\Config;

class MessageEntity extends AbstractEntity
{
    const ENTITY_TYPE         = 'MessageEntity';

    const ENTITY_TYPE_COMMAND = 'Command';

    const ENTITY_TYPE_HASHTAG = 'Hashtag';

    const ENTITY_TYPE_MENTION = 'Mention';

    const ENTITY_TYPE_EMAIL   = 'Email';

    const TYPE_MENTION        = 'mention';

    const TYPE_HASHTAG        = 'hashtag';

    const TYPE_BOT_COMMAND    = 'bot_command';

    const TYPE_URL            = 'url';

    const TYPE_EMAIL          = 'email';

    const TYPE_BOLD           = 'bold';

    const TYPE_ITALIC         = 'italic';

    const TYPE_CODE           = 'code';

    const TYPE_PRE            = 'pre';

    const TYPE_TEXT_LINK      = 'text_link';

    protected $source;

    protected $args;

    protected $type;

    protected $offset = 0;

    protected $length = 0;

    protected $url;

    protected $next = null;

    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $this->parseSource();
    }

    public function getEntityType()
    {
        $type = static::ENTITY_TYPE;

        switch ($this->type) {
            case self::TYPE_BOT_COMMAND:
                $type = self::ENTITY_TYPE_COMMAND;
                break;
            case self::TYPE_HASHTAG:
                $type = self::ENTITY_TYPE_HASHTAG;
                break;
            case self::TYPE_MENTION:
                $type = self::ENTITY_TYPE_MENTION;
                break;
            case self::TYPE_EMAIL:
                $type = self::ENTITY_TYPE_EMAIL;
                break;
        }

        return $type;
    }

    public function isCommand()
    {
        return $this->type === self::TYPE_BOT_COMMAND;
    }

    public function isHashtag()
    {
        return $this->type === self::TYPE_HASHTAG;
    }

    protected function parseSource()
    {
        if ($this->isCommand()) {
            $args = mb_substr($this->source, $this->offset, $this->offset + $this->length, 'UTF-8');

            if (preg_match('/([^\/]+)/', $args, $matches)) {
                $this->args = trim($matches[1]);
            }
        }

        $this->source = mb_substr($this->source, $this->offset, $this->length, 'UTF-8');
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function getCommand()
    {
        if (!$this->isCommand()) {
            return null;
        }

        return ltrim($this->source, '/');
    }

    public function getHashtag()
    {
        if (!$this->isHashtag()) {
            return null;
        }

        return ltrim($this->source, '#');
    }

    public function getArgs()
    {
        return $this->args;
    }

    /**
     * @return null
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @param null $next
     */
    public function setNext($next)
    {
        $this->next = $next;
    }
}
