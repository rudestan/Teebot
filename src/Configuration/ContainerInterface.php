<?php

namespace Teebot\Configuration;

interface ContainerInterface
{
    const ENV_PREFIX = 'CONFIG__';

    /**
     * @param array $config
     */
    public function __construct(array $config);

    /**
     * Returns value retrieved by path
     *
     * @param string $path
     *
     * @return mixed
     */
    public function get(string $path);
}
