<?php

/**
 * Configuration class that stores all configuration values required to run bots.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author  Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot;

use Teebot\Exception\Fatal;
use Teebot\Exception\Output;
use Teebot\Traits\Property;

class Config
{
    use Property;

    const DEFAULT_LIMIT             = 1;

    const DEFAULT_OFFSET            = -1;

    const REQUEST_TIMEOUT           = 6;

    const BOT_PREFIX                = 'bot';

    const COMMAND_NAMESPACE_PATTERN = 'Teebot\\Bot\\%s\\Command';

    const EVENT_NAMESPACE_PATTERN   = 'Teebot\\Bot\\%s\\EntityEvent';

    const CONFIG_FILENAME           = 'config.php';

    const BOT_DIR_PATTERN           = '%s/../Bot/%s';

    protected $name = null;

    protected $token;

    protected $url = 'https://api.telegram.org';

    protected $timeout = 1;

    protected $method;

    protected $file_url = 'https://api.telegram.org/file/bot';

    protected $log_file = null;

    protected $events;

    protected $command_on_first = true;

    protected $commandNamespace = null;

    protected $entityEventNamespace = null;

    protected $botDir = null;

    /**
     * Constructs configuration object with either bot name or bot config file passed.
     *
     * @param string $botConfig Path to bot's configuration file
     */
    public function __construct($botConfig = '')
    {
        $this->initBotConfiguration($botConfig);
    }

    /**
     * Initialises bot configuration via bot name or configuration file.
     *
     * @param string $botConfig Path to bot's configuration file
     *
     * @return bool
     */
    public function initBotConfiguration($botConfig = '')
    {
        try {

            if (empty($botConfig)) {
                Output::log(new Fatal("Path to configuration file was not set!"));
            }

            $this->loadConfigFile($botConfig);
        } catch (Fatal $e) {
            Output::log($e);
        }

        return true;
    }

    /**
     * Loads configuration file in JSON format.
     *
     * @param string $configFile Path to configuration file
     */
    protected function loadConfigFile($configFile)
    {
        if (!is_file($configFile) || !is_readable($configFile)) {
            Output::log(new Fatal('File "' . $configFile . '" does not exists or not readable!'));
        }

        $config = require_once($configFile);

        $this->setProperties($config);
    }

    /**
     * Returns bot token string, if the value was not set in config - default value will be used
     * 
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Returns Bot-API request url
     * 
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Returns request timeout in seconds, if the value was not set in config - default value will be used
     * 
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Returns name of the bot if it was set
     * 
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns request method name
     * 
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Returns whether command should be searched on first position in text.
     *
     * @return boolean
     */
    public function getCommandOnFirst()
    {
        return $this->command_on_first;
    }

    /**
     * Returns command's name space if bots are placed in default Bot directory
     * 
     * @return string
     */
    public function getCommandNamespace()
    {
        return $this->commandNamespace;
    }

    /**
     * Returns entity's name space if bots are placed in default Bot directory
     * 
     * @return string
     */
    public function getEntityEventNamespace()
    {
        return $this->entityEventNamespace;
    }

    /**
     * Returns base url from the files to download from Telegram's storage servers, if the value
     * was not set in config - default value will be used
     * 
     * @return string
     */
    public function getFileUrl()
    {
        return $this->file_url;
    }

    /**
     * Returns path to log file for Errors, if not set - all errors will be echoed.
     *
     * @return null|string
     */
    public function getLogFile()
    {
        return $this->log_file;
    }

    /**
     * Returns an array with defined events map, if not set default namespaces and mapping will be used.
     *
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Returns base url for the files to download from Telegram's storage servers, token will be also added.
     * If the value of file url was not set in config - default value will be used
     *
     * @return null|string
     */
    public function getFileBasePath()
    {
        if (empty($this->file_url) || empty($this->token)) {
            return null;
        }

        return $this->file_url . $this->token . '/';
    }
}
