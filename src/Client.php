<?php

namespace Teebot;

use Teebot\Entity\Message;
use Teebot\Exception;
use Teebot\Method\GetUpdates;
use Teebot\Command\Executor;
use Teebot\Exception\Fatal;

class Client
{
    const DEFAULT_DELAY = 2;

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
            $botName   = $this->getBotName($args);
            $botConfig = $this->getBotConfig($args);

            if (!$botName && !$botConfig) {
                throw new Fatal("Bot name or config should be specified!");
            }
        } catch (Fatal $e) {
            echo $e->getMessage();
            exit();
        }

        $config = new Config($botName, $botConfig);
        $this->timeout = $config->getTimeout();

        $this->executor = Executor::getInstance();
        $this->executor->initWithConfig($config);
    }

    protected function getBotName($args)
    {
        return $args['n'] ?? $args['name'] ?? '';
    }

    protected function getBotConfig($args)
    {
        return $args['c'] ?? $args['config'] ?? '';
    }

    protected function initArgs()
    {
        return [
            'limit'   => 1,
            'timeout' => $this->timeout,
            'offset'  => -1
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
     * @param array $receivedData
     *
     * @return Response
     */
    public function webhook($receivedData)
    {
        if (empty($receivedData)) {
            return null;
        }

        $response = new Response($receivedData, Message::class);

        if (!empty($response->getEntities())) {
            $this->executor->processEntities($response->getEntities());
        }

        return $response;
    }
}
