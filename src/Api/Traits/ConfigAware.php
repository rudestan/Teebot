<?php

namespace Teebot\Api\Traits;

use Teebot\Configuration\Service\AbstractContainer as ConfigContainer;

trait ConfigAware
{
    protected $configContainer;

    public function setConfig(ConfigContainer $configContainer)
    {
        $this->configContainer = $configContainer;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    public function getConfigValue($key)
    {
        return $this->configContainer->get($key);
    }
}
