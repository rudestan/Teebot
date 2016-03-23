<?php

namespace Teebot;

use Teebot\Entity\Message;
use Teebot\Exception;
use Teebot\Method\GetUpdates;
use Teebot\Command\Executor;
use Teebot\Exception\Fatal;
use Teebot\Exception\Output;

class Client
{
    const DEFAULT_LIMIT  = 1;

    const DEFAULT_OFFSET = -1;

    /**
     * @var Executor $executor Executor object
     */
    protected $executor;

    /** @var int $timeout getUpdates timeout and sleep timer for the listener */
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
        $botName   = $this->getBotName($args);
        $botConfig = $this->getBotConfig($args);

        if (!$botName && !$botConfig) {
            Output::log(new Fatal("Bot name or config should be specified!"));
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

    public function getUpdates($offset = self::DEFAULT_LIMIT, $limit = self::DEFAULT_OFFSET, $silentMode = false)
    {
        $method = (new GetUpdates())
            ->setOffset($offset)
            ->setLimit($limit)
            ->setTimeout($this->timeout);

        return $this->executor->callRemoteMethod($method, $silentMode);
    }

    public function flush()
    {
        $response = $this->getUpdates(static::DEFAULT_OFFSET, static::DEFAULT_LIMIT, true);

        return $response instanceof Response ? $response->getOffset() : -1;
    }

    public function listen()
    {
        $offset = $this->flush();

        while (1) {
            $response = $this->getUpdates($offset);

            if ($response instanceof Response) {
                $offset = $response->getOffset();
            }

            sleep($this->timeout);
        }
    }

    /**
     * @param array $receivedData
     * @param bool  $silentMode
     *
     * @return Response
     */
    public function webhook($receivedData = [], $silentMode = false)
    {
        if (empty($receivedData)) {
            $receivedData = file_get_contents("php://input");
        }

        if (empty($receivedData)) {
            return null;
        }

        return $this->executor->getWebhookResponse($receivedData, $silentMode);
    }
}
