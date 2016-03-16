<?php

namespace Teebot;

use Teebot\Exception\Fatal;

class Config
{
    const DEFAULT_TIMEOUT = 6;

    const BOT_PREFIX = 'bot';

    const COMMAND_NAMESPACE_PATTERN = 'Teebot\\Bot\\%s\\Command';

    const EVENT_NAMESPACE_PATTERN = 'Teebot\\Bot\\%s\\EntityEvent';

    const CONFIG_FILENAME = 'config.json';

    const BOT_DIR_PATTERN = '%s/../Bot/%s';

    protected $botName = null;

    protected $token;

    protected $url;

    protected $timeout;

    protected $method;

    protected $catch_unknown_command = null;

    protected $file_url = null;

    protected $commandNamespace = null;

    protected $entityEventNamespace = null;

    protected $botDir = null;

    public function __construct(string $botName = '', $botConfig = '')
    {
        $this->initBotConfiguration($botName, $botConfig);
    }

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
                throw new Fatal("Path to configuration file was not sent!");
            }

            $this->loadConfig($botConfig);
        } catch (Fatal $e) {
            echo $e->getMessage();

            exit();
        }

        return true;
    }

    protected function getBotDir($botName)
    {
        $dir = sprintf(
            static::BOT_DIR_PATTERN,
            __DIR__,
            $botName
        );

        if (!file_exists($dir)) {
            throw new Fatal('Bot does not exist!');
        }

        return realpath($dir) . "/";
    }

    protected function setNamespaces($botName)
    {
        $this->commandNamespace = sprintf(static::COMMAND_NAMESPACE_PATTERN, $botName);
        $this->entityEventNamespace = sprintf(static::EVENT_NAMESPACE_PATTERN, $botName);
    }

    protected function loadConfig($configFile)
    {
        if (!is_file($configFile) || !is_readable($configFile)) {
            throw new Fatal('File "' . $configFile . '" does not exists or not readable!');
        }

        $config = file_get_contents($configFile);
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
