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

use Teebot\Exception;
use Teebot\Method\GetUpdates;
use Teebot\Command\Executor;
use Teebot\Exception\Fatal;
use Teebot\Exception\Output;

class Client
{
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

    /**
     * Constructs Client instance and initialises configuration and default values.
     *
     * @param array $args Array of arguments to create the client, otherwise arguments from command line
     * will be used.
     */
    public function __construct($args = [])
    {
        if (empty($args)) {
            $args = getopt($this->cliOptions['short'], $this->cliOptions['long']);
        }

        $this->init($args);
    }

    /**
     * Initialises the client and loads Configuration.
     *
     * @param array $args Array of initialisation arguments
     */
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

    /**
     * Returns bot name from initialisation arguments
     *
     * @param array $args Array with initialisation values
     *
     * @return string
     */
    protected function getBotName($args)
    {
        return $args['n'] ?? $args['name'] ?? '';
    }

    /**
     * Returns configuration file path from initialisation arguments
     *
     * @param array $args Array with initialisation values
     *
     * @return string
     */
    protected function getBotConfig($args)
    {
        return $args['c'] ?? $args['config'] ?? '';
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
    public function getUpdates($offset = Config::DEFAULT_LIMIT, $limit = Config::DEFAULT_OFFSET, $silentMode = false)
    {
        $method = (new GetUpdates())
            ->setOffset($offset)
            ->setLimit($limit)
            ->setTimeout($this->timeout);

        return $this->executor->callRemoteMethod($method, $silentMode);
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

            sleep($this->timeout);
        }
    }

    /**
     * Returns Response object built from received data. Method should be used if
     * bot is running in webhook mode.
     *
     * @param array $receivedData Received data from Telegram's webhook call. Not required, but could
     *                            be passed manually. If not passed - php input will be used to get the data.
     * @param bool  $silentMode   If set to true then the events, mapped to
     *                            the entities in the result will not be triggered
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
