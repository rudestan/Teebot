<?php

namespace Teebot\Entity;

class Command extends AbstractEntity
{
    const ENTITY_TYPE             = 'Command';

    const PREFIX          = '/';

    const ARGS_SEPARATOR  = ' ';

    const PARTS_DELIMITER = '_';

    const PATTERN = '/^\/[a-zA-Z_]+.*$/';

    protected $text;

    protected $name;

    protected $args;

    public function __construct(array $data)
    {
        $command = null;
        $args    = null;

        if (isset($data['text'])) {
            $command = $this->getCommandFromText($data['text']);

            if ($command) {
                $args = $this->getArgsFromText($command, $data['text']);
            }

            $data = [
                'name' => $command,
                'args' => $args
            ];
        }

        parent::__construct($data);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getArgs()
    {
        return $this->args;
    }

    protected function getCommandFromText($text)
    {
        $command = null;

        if (!is_string($text) || !strlen($text) || $text[0] !== static::PREFIX) {
            return $command;
        }

        if (strpos($text, static::ARGS_SEPARATOR) !== false) {
            $parts = explode(static::ARGS_SEPARATOR, $text);

            $text = trim($parts[0]);
        }

        $command = trim(substr($text, 1, strlen($text) - 1));

        return $command;
    }

    protected function getArgsFromText($command, $text)
    {
        $length = strlen(static::PREFIX . $command);

        $argString = trim(substr($text, $length));

        if (strlen($argString)) {
            return $argString;
        }

        return null;
    }
}
