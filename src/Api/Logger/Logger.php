<?php

namespace Teebot\Api\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Logger as Monolog;
use Teebot\Api\Traits\ConfigAware;

class Logger
{
    protected static $instance;

    /**
     * @var Logger
     */
    protected $logger;

    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function init()
    {
        $filename     = TEEBOT_ROOT . $this->getConfigValue('logger.filename');
        $this->logger = new Monolog('Teebot');
        $this->logger->pushHandler(
            new StreamHandler($filename, Monolog::WARNING)
        );
    }

    public function warning($msg)
    {
        $this->logger->warning($msg);
    }
}
