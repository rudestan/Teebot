<?php

namespace Teebot\Configuration;

use Teebot\Configuration\Service\AbstractLoader;

class TeebotLoader extends AbstractLoader
{
    protected function getConfiguration()
    {
        return new TeebotConfig();
    }

    protected function initContainer($config)
    {
        $container = TeebotContainer::getInstance();

        return $container->initWithConfig($config);
    }
}