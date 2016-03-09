<?php

namespace Teebot\Api;

use Teebot\Api\Exception;
use Teebot\Api\Method\GetUpdates;
use Teebot\Api\Command\Executor;
use Teebot\Api\Exception\Fatal;

class Listener
{
    const DEFAULT_DELAY = 2;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Executor $executor
     */
    protected $executor;

    protected $timeout;

    public function __construct($args)
    {
        try {
            $botName = $this->getBotName($args);

            if (!$botName) {
                throw new Fatal("No bot specified!");
            }
        } catch (Fatal $e) {
            echo $e->getMessage();
            exit();
        }

        $config = Config::getInstance();
        $config->initBotConfiguration($botName);

        $this->timeout = $config->getTimeout();

        $this->request = Request::getInstance();
        $this->request->setConfig($config);
        $this->executor = new Executor();
    }

    protected function getBotName($args)
    {
        return $args[1] ?? null;
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
        $response = $this->executor->callRemoteMethod(GetUpdates::NAME, [], false);
        $args = $this->initArgs();

        while (1) {

            if ($response && $response instanceof Response) {
                $args['offset'] = $response->getOffset();
            }

            $response = $this->executor->callRemoteMethod(GetUpdates::NAME, $args);

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
