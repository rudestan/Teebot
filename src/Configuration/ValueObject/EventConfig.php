<?php

declare(strict_types=1);

namespace Teebot\Configuration\ValueObject;

/**
 * EventConfig value object
 */
class EventConfig
{
    /**
     * @var string
     */
    protected $command;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        if (isset($data['command'])) {
            $this->command = $data['command'];
        }
        if (isset($data['type'])) {
            $this->type = $data['type'];
        }
        if (isset($data['class'])) {
            $this->class = $data['class'];
        }
        if (isset($data['params'])) {
            $this->params = $data['params'];
        }
    }

    /**
     * @return string|null
     */
    public function getCommand(): ?string
    {
        return $this->command;
    }

    /**
     * @return  string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return  string|null
     */
    public function getClass(): ?string
    {
        return $this->class;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
