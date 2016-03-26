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

class Config
{
    const DEFAULT_LIMIT             = 1;

    const DEFAULT_OFFSET            = -1;

    const REQUEST_TIMEOUT           = 6;

    const BOT_PREFIX                = 'bot';

    const COMMAND_NAMESPACE_PATTERN = 'Teebot\\Bot\\%s\\Command';

    const EVENT_NAMESPACE_PATTERN   = 'Teebot\\Bot\\%s\\EntityEvent';

    const CONFIG_FILENAME           = 'config.json';

    const BOT_DIR_PATTERN           = '%s/../Bot/%s';

    protected $botName = null;

    protected $token;

    protected $url = 'https://api.telegram.org';

    protected $timeout = 1;

    protected $method;

    protected $file_url = 'https://api.telegram.org/file/bot';

    protected $log_file = null;

    protected $events;

    protected $commandNamespace = null;

    protected $entityEventNamespace = null;

    protected $botDir = null;

    /**
     * Constructs configuration object with either bot name or bot config file passed.
     *
     * @param string $botName   The name of the bot to execute
     * @param string $botConfig Path to bot's configuration file
     */
    public function __construct(string $botName = '', $botConfig = '')
    {
        $this->initBotConfiguration($botName, $botConfig);
    }

    /**
     * Initialises bot configuration via bot name or configuration file.
     *
     * @param string $botName   The name of the bot to execute
     * @param string $botConfig Path to bot's configuration file
     *
     * @return bool
     */
    public function initBotConfiguration(string $botName = '', $botConfig = '')
    {
        $this->botName = $botName;

        try {
            if (!empty($botName)) {
                $this->botDir = $this->getBotDir($botName);
                $botConfig    = $this->botDir . static::CONFIG_FILENAME;

                $this->setNamespaces($botName);
            }

            if (empty($botConfig)) {
                Output::log(new Fatal("Path to configuration file was not sent!"));
            }

            $this->loadConfig($botConfig);
        } catch (Fatal $e) {
            Output::log($e);
        }

        return true;
    }

    /**
     * Returns bot directory built with default path pattern.
     *
     * @param string $botName The name of the bot to execute
     *
     * @return string
     */
    protected function getBotDir(string $botName) : string
    {
        $dir = sprintf(
            static::BOT_DIR_PATTERN,
            __DIR__,
            $botName
        );

        if (!file_exists($dir)) {
            Output::log(new Fatal('Bot does not exist!'));
        }

        return realpath($dir) . "/";
    }

    /**
     * Sets namespace for command and event entities classes to be able to load them via autoloader in the future.
     *
     * @param string $botName The name of the bot to execute
     */
    protected function setNamespaces(string $botName)
    {
        $this->commandNamespace     = sprintf(static::COMMAND_NAMESPACE_PATTERN, $botName);
        $this->entityEventNamespace = sprintf(static::EVENT_NAMESPACE_PATTERN, $botName);
    }

    /**
     * Loads configuration file in JSON format.
     *
     * @param string $configFile Path to configuration file
     */
    protected function loadConfig($configFile)
    {
        if (!is_file($configFile) || !is_readable($configFile)) {
            Output::log(new Fatal('File "' . $configFile . '" does not exists or not readable!'));
        }

        $config      = file_get_contents($configFile);
        $configArray = json_decode($config, true);

        foreach ($configArray as $name => $value) {
            if (property_exists($this, $name)) {
                $this->{$name} = $value;
            }
        }
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
    public function getBotName()
    {
        return $this->botName;
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
