<?php

declare(strict_types=1);

namespace Teebot\Configuration;

use Symfony\Component\Config\{
    Definition\Processor,
    Definition\ConfigurationInterface,
    Exception\FileLoaderLoadException,
    FileLocator
};
use Symfony\Component\Yaml\Yaml;
use Dotenv\{
    Dotenv,
    Exception\InvalidPathException
};

/**
 * Abstract configuration loader
 *
 * @package Teebot\Configuration
 */
abstract class AbstractLoader
{
    protected const FILE_NAME = 'config%s.yml';

    /**
     * @var string $path
     */
    protected $path;

    /**
     * @var string $fileName
     */
    protected $fileName;

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->initEnv($path);

        $this->path     = $path;
        $this->fileName = $this->getFileName();
    }

    /**
     * Loads configuration
     *
     * @return ContainerInterface
     */
    public function load(): ContainerInterface
    {
        $configFile = $this->getConfigFile();
        $data       = Yaml::parse(file_get_contents($configFile));

        return $this->loadFromArray($data);
    }

    /**
     * Loads configuration from array
     *
     * @param array $configData
     *
     * @return ContainerInterface
     */
    public function loadFromArray(array $configData): ContainerInterface
    {
        $config = $this->processConfig($configData);

        return $this->initContainer($config);
    }

    /**
     * Returns config file name based on the current environment
     *
     * @return string
     */
    protected function getFileName(): string
    {
        $env = getenv('ENV') ? '_' . getenv('ENV') : '';

        return sprintf(static::FILE_NAME, $env);
    }

    /**
     * Initializes and loads the DotEnv, suppress the DotEnv exception to continue loading process
     *
     * @param string $path
     */
    protected function initEnv(string $path)
    {
        try {
            $dotenv = new Dotenv($path);
            $dotenv->load();
        } catch (InvalidPathException $e) {
        }
    }

    /**
     * Returns path to config file
     *
     * @return string
     *
     * @throws FileLoaderLoadException
     */
    protected function getConfigFile(): string
    {
        $locator    = new FileLocator($this->path);
        $configFile = $locator->locate($this->fileName, null, true);

        if (!is_readable($configFile)) {
            throw new FileLoaderLoadException('Config file is not readable!');
        }

        return $configFile;
    }

    /**
     * Processes the config
     *
     * @param array $data
     *
     * @return array
     */
    protected function processConfig(array $data): array
    {
        $processor       = new Processor();
        $configuration   = $this->getConfiguration();
        $processedConfig = $processor->processConfiguration($configuration, $data);

        return $processedConfig;
    }

    /**
     * @return ConfigurationInterface
     */
    abstract protected function getConfiguration(): ConfigurationInterface;

    /**
     * @param array $config
     *
     * @return ContainerInterface
     */
    abstract protected function initContainer(array $config): ContainerInterface;
}
