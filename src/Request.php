<?php

namespace Teebot;

use Teebot\Method\AbstractMethod;
use Teebot\Exception\Critical;

class Request
{
    const METHOD_CLASSNAME_TEMPLATE = 'Teebot\\Method\\%s';

    const METHOD_GET = 'GET';

    protected $ch;

    /**
     * @var Config $config Instance of configuration class
     */
    protected $config;

    protected static $instance;

    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

    public function exec($method, $args = [], $parent = null)
    {
        $methodInstance = $this->getMethodClassInstance($method, $args);
        $returnType = $methodInstance->getReturnEntityType();
        $result = $this->sendRequest($methodInstance);

        return $this->getResponseObject($result, $returnType, $parent);
    }

    protected function sendRequest(AbstractMethod $methodInstance)
    {
        $name = $methodInstance->getName();

        if (!$this->ch) {
            $this->ch = curl_init();
        }

        // Default method is always POST
        if ($this->config->getMethod() !== self::METHOD_GET) {
            curl_setopt($this->ch, CURLOPT_POST, 1);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $methodInstance->getArgsAsString());

            $url = $this->buildUrl($name);
        } else {
            $url = $this->buildUrl($name, $methodInstance->getArgsAsString());
        }

        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, Config::DEFAULT_TIMEOUT);

        return curl_exec($this->ch);
    }

    protected function getResponseObject($receivedData, $entityType, $caller = null)
    {
        $response = null;

        try {
            $response = new Response($receivedData, $entityType, $caller);
        } catch (Critical $e) {
            echo $e->getMessage();
        }

        return $response;
    }

    protected function getMethodClassInstance($methodName, $args) : AbstractMethod
    {
        $methodClassName = sprintf(self::METHOD_CLASSNAME_TEMPLATE, ucfirst($methodName));

        if (class_exists($methodClassName)) {

            /** @var AbstractMethod $methodInstance */
            return new $methodClassName($args);
        }

        return null;
    }

    protected function buildUrl($method, $args = null)
    {
        $url = sprintf(
            '%s/%s%s/%s',
            $this->config->getUrl(),
            Config::BOT_PREFIX,
            $this->config->getToken(),
            $method
        );

        if ($args && strlen($args)) {
            $url .= '?' . $args;
        }

        return $url;
    }

    public function __destruct()
    {
        if ($this->ch) {
            curl_close($this->ch);
        }
    }
}
