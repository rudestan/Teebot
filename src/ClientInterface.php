<?php

namespace Teebot;

use Teebot\Configuration\AbstractContainer;
use Teebot\Api\Response;

interface ClientInterface
{
    /**
     * @param AbstractContainer $config
     */
    public function __construct(AbstractContainer $config);

    /**
     * Returns the latest updates from Telegram's API server
     *
     * @param int  $offset     Offset for the updates list
     * @param int  $limit      Limit of the updates to get
     * @param bool $silentMode If set to true then the events, mapped (in config or by default) to
     *                         the entities in the result will not be triggered
     * @return Response
     */
    public function getUpdates($offset, $limit, $silentMode): Response;

    /**
     * Flushes the results and resets the offset pointer to the latest updates. Returns last offset.
     * Should be used to skip previous results from dialogs during first listener's start. Must not
     * be used for webhook.
     *
     * @return int
     */
    public function flush(): int;

    /**
     * Starts listener in daemon mode for receiving the updates from the chats. Should be used if webhook is not set.
     */
    public function listen();

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
    public function webhook($receivedData, $silentMode): Response;
}
