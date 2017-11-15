<?php

namespace Teebot\Configuration;

class Loader extends AbstractLoader
{
    protected function getConfiguration()
    {
        return new Config();
    }

    protected function initContainer($config)
    {
        return new Container($config);
    }
}
