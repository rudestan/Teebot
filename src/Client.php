<?php

/**
 * Client class for Telegram Bot-API. Can be used for running bots in two supported modes:
 * daemon listener mode and webhook mode. Can easily be instantiated in any place of your application.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author  Stanislav Drozdov <rudestan@gmail.com>
 */

declare(strict_types=1);

namespace Teebot;

use Teebot\Configuration\{
    AbstractContainer,
    Config
};
use Teebot\Api\{
    Logger\Logger,
    Command\Processor,
    HttpClient,
    Method\GetUpdates,
    Response
};

class Client implements ClientInterface
{
    /**
     * @var AbstractContainer
     */
    protected $config;

    /**
     * @var Processor $processor
     */
    protected $processor;

    /**
     * @var Logger
     */
    protected $logger;

    public function __construct(AbstractContainer $config)
    {
        define('TEEBOT_ROOT', realpath(__DIR__ . '/../'));

        $this->init($config);
    }

    /**
     * Initializes the Client
     *
     * @param AbstractContainer $config
     */
    protected function init(AbstractContainer $config)
    {
        $this->config    = $config;
        $this->processor = new Processor($config, new HttpClient($config));
        $this->logger    = new Logger($config);
    }

    /**
     * Returns the latest updates from Telegram's API server
     *
     * @param int  $offset     Offset for the updates list
     * @param int  $limit      Limit of the updates to get
     * @param bool $silentMode If set to true then the events, mapped (in config or by default) to
     *                         the entities in the result will not be triggered
     * @return Response
     */
    public function getUpdates(
        $offset = Config::DEFAULT_OFFSET,
        $limit = Config::DEFAULT_LIMIT,
        $silentMode = false
    ): Response {
        $method = (new GetUpdates())
            ->setOffset($offset)
            ->setLimit($limit)
            ->setTimeout($this->config->get('timeout'));

        return $this->processor->call($method, $silentMode);
    }

    /**
     * Flushes the results and resets the offset pointer to the latest updates. Returns last offset.
     * Should be used to skip previous results from dialogs during first listener's start. Must not
     * be used for webhook.
     *
     * @return int
     */
    public function flush(): int
    {
        $response = $this->getUpdates(Config::DEFAULT_OFFSET, Config::DEFAULT_LIMIT, true);

        return $response instanceof Response ? $response->getOffset() : -1;
    }

    /**
     * Starts listener in daemon mode for receiving the updates from the chats. Should be used if webhook is not set.
     */
    public function listen()
    {
        $offset = $this->flush();

        while (1) {
            try {
                $response = $this->getUpdates($offset);

                if ($response instanceof Response) {
                    $offset = $response->getOffset();
                }
            } catch (\Exception $e){
                $this->logger->exception($e);
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
    public function webhook($receivedData = '', $silentMode = false): Response
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
