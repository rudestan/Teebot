<?php

declare(strict_types=1);

namespace Teebot\Api\Logger;

use Monolog\{
    Handler\StreamHandler,
    Logger as Monolog
};
use Teebot\Configuration\ContainerInterface;
use Exception;

class Logger
{
    /**
     * @var ContainerInterface $config
     */
    protected $config;

    /**
     * @var Monolog
     */
    protected $logger;

    /**
     * @param ContainerInterface $config
     */
    public function __construct(ContainerInterface $config)
    {
        $this->config = $config;
        $filename     = TEEBOT_ROOT . $this->config->get('logger.filename');
        $this->logger = new Monolog('Teebot');
        $this->logger->pushHandler(
            new StreamHandler($filename, Monolog::WARNING)
        );
    }

    /**
     * @param Exception $exception
     */
    public function exception(Exception $exception)
    {
        $this->logger->warning($exception->getMessage());
    }

    /**
     * @param string $msg
     */
    public function warning(string $msg)
    {
        $this->logger->warning($msg);
    }
}
