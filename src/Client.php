<?php

/**
 * Client class for Telegram Bot-API. Can be used for running bots in two supported modes:
 * daemon listener mode and webhook mode. Can easily be instantiated in any place of your application.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author  Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot;

use Teebot\Api\Logger\Logger;
use Teebot\Api\Command\Processor;
use Teebot\Api\HttpClient;
use Teebot\Configuration\Service\AbstractContainer as ConfigContainer;
use Teebot\Configuration\TeebotConfig as Config;
use Teebot\Api\Method\GetUpdates;
use Teebot\Api\Response;

class Client
{
    /**
     * @var ConfigContainer
     */
    protected $config;

    /**
     * @var Processor $processor
     */
    protected $processor;

    protected $logger;

    public function __construct(ConfigContainer $config)
    {
        define('TEEBOT_ROOT', realpath(__DIR__ . '/../'));

        $this->init($config);/*

        $this
            ->getLogger()
            ->setConfig($config)
            ->init();*/
    }

    protected function init($config)
    {
        $this->config    = $config;
        $httpClient      = new HttpClient($config);
        $this->processor = new Processor($config, $httpClient);
    }

    /**
     * Requests and returns the latest updates from Telegram's API server
     *
     * @param int  $offset     Offset for the updates list
     * @param int  $limit      Limit of the updates to get
     * @param bool $silentMode If set to true then the events, mapped (in config or by default) to
     *                         the entities in the result will not be triggered
     * @return Response
     */
    public function getUpdates($offset = Config::DEFAULT_OFFSET, $limit = Config::DEFAULT_LIMIT, $silentMode = false)
    {
        $method = (new GetUpdates())
            ->setOffset($offset)
            ->setLimit($limit)
            ->setTimeout($this->config->get('timeout'));

        return $this->processor->call($method, $silentMode);
    }

    /**
     * Flushes the results and resets the offset pointer to the latest updates. Returns last offset.
     * Should be used to skip previous results from dialogs during first listener's start, should not
     * be used for webhook.
     *
     * @return int
     */
    public function flush()
    {
        $response = $this->getUpdates(Config::DEFAULT_OFFSET, Config::DEFAULT_LIMIT, true);

        return $response instanceof Response ? $response->getOffset() : -1;
    }

    /**
     * Starts listener daemon for getting the updates from the chats. Should be used if webhook is not set.
     */
    public function listen()
    {
        $offset = $this->flush();

        while (1) {
            $response = $this->getUpdates($offset);

            if ($response instanceof Response) {
                $offset = $response->getOffset();
            }

            sleep($this->config->get('timeout'));
        }
    }

    /**
     * Returns Response object built from received data. Method should be used if
     * bot is running in webhook mode.
     *
     * @param string $receivedData Received data from Telegram's webhook call. Not required, but could
     *                             be passed manually. If not passed - php input will be used to get the data.
     * @param bool   $silentMode   If set to true then the events, mapped to
     *                             the entities in the result will not be triggered
     * @return Response
     */
    public function webhook($receivedData = '', $silentMode = false)
    {
        if (empty($receivedData)) {
            $receivedData = file_get_contents("php://input");
        }

        if (empty($receivedData)) {
            return null;
        }

        return $this->processor->getWebhookResponse($receivedData, $silentMode);
    }
}
