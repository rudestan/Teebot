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
        return new TeebotContainer($config);
    }
}