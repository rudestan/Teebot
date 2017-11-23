<?php

declare(strict_types=1);

namespace Teebot\Configuration;

use Symfony\Component\Config\Definition\ConfigurationInterface;

class Loader extends AbstractLoader
{
    /**
     * Returns Configuration instance
     *
     * @return ConfigurationInterface
     */
    protected function getConfiguration(): ConfigurationInterface
    {
        return new Config();
    }

    /**
     * Returns configuration Container instance
     *
     * @param array $config
     *
     * @return ContainerInterface
     */
    protected function initContainer(array $config): ContainerInterface
    {
        return new Container($config);
    }
}
