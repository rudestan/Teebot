<?php

declare(strict_types=1);

namespace Teebot\Configuration;

use RecursiveArrayIterator;
use RecursiveIteratorIterator;

abstract class AbstractContainer implements ContainerInterface
{
    /**
     * @var array
     */
    protected $values;

    /**
     * @var null|$this
     */
    protected static $instance = null;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->values = $this->applyEnvParamsRecursively($config);
    }

    /**
     * Replaces placeholders on environment variables recursively
     *
     * @param array $data
     *
     * @return array
     */
    protected function applyEnvParamsRecursively(array $data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->applyEnvParamsRecursively($value);

                continue;
            }

            $value = (string) $value;

            if (preg_match_all('/%\w+%/', $value, $matches) && isset($matches[0])) {
                $tokens = $matches[0];

                $data[$key] = $this->getValueFromEnv($tokens, $value);
            }
        }

        return $data;
    }

    /**
     * Returns environment value
     *
     * @param array  $tokens
     * @param string $str
     *
     * @return mixed
     */
    protected function getValueFromEnv(array $tokens, string $str): string
    {
        $replace = [];

        foreach ($tokens as $token) {
            $envKey   = ContainerInterface::ENV_PREFIX . strtoupper(substr($token, 1, strlen($token) - 2));
            $envValue = getenv($envKey);

            if ($envValue) {
                $replace[$token] = $envValue;
            }
        }

        if (empty($replace)) {
            return $str;
        }

        return str_replace(array_keys($replace), array_values($replace), $str);
    }

    /**
     * Returns value by path from the array. To access nested array values
     * the path like "key.subarray_key.subarray_key2...." can be used.
     *
     * @param string $path
     *
     * @return mixed|null
     */
    protected function getValueByPath(string $path)
    {
        $rIterator = new RecursiveIteratorIterator(
            new RecursiveArrayIterator($this->values),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($rIterator as $k => $value) {
            $keys = [];
            foreach (range(0, $rIterator->getDepth()) as $depth) {
                $curKey = $rIterator->getSubIterator($depth)->key();
                $keys[] = $curKey;
            }
            $key = implode('.', $keys);

            if ($key === $path) {
                return $value;
            }
        }

        return null;
    }

    /**
     * Returns value retrieved by path
     *
     * @param string $path
     *
     * @return mixed|null
     */
    public function get(string $path)
    {
        $value = $this->getValueByPath($path);

        return $value;
    }
}
