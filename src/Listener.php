<?php

namespace Teebot;

use Teebot\Exception;
use Teebot\Method\GetUpdates;
use Teebot\Command\Executor;
use Teebot\Exception\Fatal;

class Listener
{
    const DEFAULT_DELAY = 2;

    /**
     * @var Request
     */
//    protected $request;

    /**
     * @var Executor $executor
     */
    protected $executor;

    protected $timeout;

    protected $cliOptions = [
        'short' => 'n:c:',
        'long'  => ['name:', 'config']
    ];

    public function __construct($args = [])
    {
        if (empty($args)) {
            $args = getopt($this->cliOptions['short'], $this->cliOptions['long']);
        }

        $this->init($args);
    }

    protected function init($args) {
        try {
            $botName = $this->getBotName($args);

            if (!$botName) {
                throw new Fatal("No bot specified!");
            }
        } catch (Fatal $e) {
            echo $e->getMessage();
            exit();
        }

        $botConfig = $this->getBotConfig($args);

        $config = new Config($botName, $botConfig);
        $this->timeout = $config->getTimeout();

        $this->executor = Executor::getInstance();
        $this->executor->initWithConfig($config);
    }

    protected function getBotName($args)
    {
        return $args['n'] ?? $args['name'] ?? null;
    }

    protected function getBotConfig($args)
    {
        return $args['c'] ?? $args['config'] ?? null;
    }

    protected function initArgs()
    {
        return [
            'limit' => 1,
            'timeout' => $this->timeout
        ];
    }

    public function listen()
    {
        // Flush old messages and reset offset to the last position
        $method   = new GetUpdates($this->initArgs());
        $response = $this->executor->callRemoteMethod($method, true);

        while (1) {

            if ($response && $response instanceof Response) {
                $method->setOffset($response->getOffset());
            }

            $response = $this->executor->callRemoteMethod($method);

            sleep($this->timeout);
        }
    }

    /**
     * @TODO: implement webhook capability
     * @param $args
     */
    public function webhook($args)
    {
    }
}
