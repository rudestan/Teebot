<?php

namespace Teebot\Configuration\Service;

use \RecursiveArrayIterator;
use \RecursiveIteratorIterator;

abstract class AbstractContainer
{
    const ENV_PREFIX = 'CONFIG__';

    /**
     * @var array
     */
    protected $values;

    protected static $instance = null;

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function initWithConfig(array $config)
    {
        $this->values = $this->applyEnvParamsRecursively($config);

        return $this;
    }

    protected function applyEnvParamsRecursively(array $data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->applyEnvParamsRecursively($value);

                continue;
            }

            if (preg_match_all('/%\w+%/', $value, $matches) && isset($matches[0])) {
                $tokens = $matches[0];

                $data[$key] = $this->getValueFromEnv($tokens, $value);
            }
        }

        return $data;
    }

    protected function getValueFromEnv($tokens, $str)
    {
        $replace = [];

        foreach ($tokens as $token) {
            $envKey   = static::ENV_PREFIX . strtoupper(substr($token, 1, strlen($token) - 2));
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

    protected function getValueByPath($path)
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

    public function get($path)
    {
        $value = $this->getValueByPath($path);

        return $value;
    }
}