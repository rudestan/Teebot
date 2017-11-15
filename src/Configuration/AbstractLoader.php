<?php

namespace Teebot\Configuration;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Exception\FileLoaderLoadException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

abstract class AbstractLoader
{
    const FILE_NAME = 'config%s.yml';

    /**
     * @var string $path
     */
    protected $path;

    /**
     * @var string $fileName
     */
    protected $fileName;

    public function __construct($path)
    {
        $this->initEnv($path);

        $this->path     = $path;
        $this->fileName = $this->getFileName();
    }

    public function load()
    {
        $configFile = $this->getConfigFile();
        $data       = Yaml::parse(file_get_contents($configFile));

        return $this->loadFromArray($data);
    }

    public function loadFromArray($configData)
    {
        $config = $this->processConfig($configData);

        return $this->initContainer($config);
    }

    protected function getFileName()
    {
        $env = getenv('ENV') ? '_' . getenv('ENV') : '';

        return sprintf(static::FILE_NAME, $env);
    }

    protected function initEnv($path)
    {
        try {
            $dotenv = new Dotenv($path);
            $dotenv->load();
        } catch (InvalidPathException $e) {
        }
    }

    protected function getConfigFile()
    {
        $locator    = new FileLocator($this->path);
        $configFile = $locator->locate($this->fileName, null, true);

        if (!is_readable($configFile)) {
            throw new FileLoaderLoadException('Config file is not readable!');
        }

        return $configFile;
    }

    protected function processConfig($data)
    {
        $processor       = new Processor();
        $configuration   = $this->getConfiguration();
        $processedConfig = $processor->processConfiguration($configuration, $data);

        return $processedConfig;
    }

    abstract protected function getConfiguration();

    abstract protected function initContainer($config);
}
