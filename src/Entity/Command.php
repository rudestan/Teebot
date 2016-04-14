<?php

namespace Teebot\Entity;

use Teebot\Command\Executor;

class Command extends AbstractEntity
{
    const ENTITY_TYPE             = 'Command';

    const PREFIX          = '/';

    const ARGS_SEPARATOR  = ' ';

    const PARTS_DELIMITER = '_';

    const PATTERN_COMMAND_ON_FIRST = '/^\/[a-zA-Z_]+.*$/';

    const PATTERN_COMMAND_ON_ANY = '/\/[a-zA-Z_]+.*$/';

    const PATTERN_COMMAND_DATA = '/.*\/(?P<name>\w+)\b(?P<args>.*)$/';

    protected $text;

    protected $name;

    protected $args;

    public function __construct(array $data)
    {
        if (isset($data['text'])) {
            $args    = null;
            $command = $this->getCommandDataFromText($data['text']);

            if ($command) {
                $data = [
                    'name' => $command['name'],
                    'args' => $command['args']
                ];
            }
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

    protected function getCommandDataFromText($text)
    {
        $commandOnFirst = Executor::getInstance()->getConfig()->getCommandOnFirst();
        $command        = null;

        if (!is_string($text) ||
            !strlen($text) ||
            ($commandOnFirst === true && $text[0] != self::PREFIX) ||
            strpos($text, self::PREFIX) === false
        ) {
            return $command;
        }

        preg_match(self::PATTERN_COMMAND_DATA, $text, $matches);

        if ($matches) {
            $matches = array_map('trim', $matches);
        }

        return $matches;
    }
}
