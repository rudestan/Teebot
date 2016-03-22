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
    const DEFAULT_TIMEOUT           = 6;

    const BOT_PREFIX                = 'bot';

    const COMMAND_NAMESPACE_PATTERN = 'Teebot\\Bot\\%s\\Command';

    const EVENT_NAMESPACE_PATTERN   = 'Teebot\\Bot\\%s\\EntityEvent';

    const CONFIG_FILENAME           = 'config.json';

    const BOT_DIR_PATTERN           = '%s/../Bot/%s';

    protected $botName = null;

    protected $token;

    protected $url;

    protected $timeout;

    protected $method;

    protected $catch_unknown_command = null;

    protected $file_url = null;

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
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @return null
     */
    public function getBotName()
    {
        return $this->botName;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return null
     */
    public function getCatchUnknownCommand()
    {
        return $this->catch_unknown_command;
    }

    /**
     * @return null
     */
    public function getCommandNamespace()
    {
        return $this->commandNamespace;
    }

    /**
     * @return null
     */
    public function getEntityEventNamespace()
    {
        return $this->entityEventNamespace;
    }

    /**
     * @return null
     */
    public function getFileUrl()
    {
        return $this->file_url;
    }

    /**
     * @return string|null
     */
    public function getLogFile()
    {
        return $this->log_file;
    }

    /**
     * @return mixed
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @return null
     */
    public function getFileBasePath()
    {
        if (empty($this->file_url) || empty($this->token)) {
            return null;
        }

        return $this->file_url . $this->token . '/';
    }
}
