<?php

namespace Teebot\Api\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Logger as Monolog;
use Teebot\Configuration\AbstractContainer as ConfigContainer;

class Logger
{
    /**
     * @var ConfigContainer $config
     */
    protected $config;

    /**
     * @var Monolog
     */
    protected $logger;

    public function __construct(ConfigContainer $config)
    {
        $this->config = $config;
        $filename     = TEEBOT_ROOT . $this->config->get('logger.filename');
        $this->logger = new Monolog('Teebot');
        $this->logger->pushHandler(
            new StreamHandler($filename, Monolog::WARNING)
        );
    }

    public function exception(\Exception $exception)
    {
        $this->logger->warning($exception->getMessage());
    }

    public function warning($msg)
    {
        $this->logger->warning($msg);
    }
}
