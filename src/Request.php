<?php

namespace Teebot;

use Teebot\Method\AbstractMethod;
use Teebot\Exception\Critical;

class Request
{
    const METHOD_GET = 'GET';

    const CONTENT_TYPE_MULTIPART = 'Content-Type:multipart/form-data';

    protected $ch;

    /**
     * @var Config $config Instance of configuration class
     */
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function exec(AbstractMethod $method, $parent = null)
    {
        $entityClass = $method->getReturnEntity();
        $result      = $this->sendRequest($method);

        return $this->getResponseObject($result, $entityClass, $parent);
    }

    protected function sendRequest(AbstractMethod $methodInstance)
    {
        if (!$this->ch) {
            $this->ch = curl_init();
        }

        $name        = $methodInstance->getName();
        $curlOptions = [
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HEADER         => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT        => Config::DEFAULT_TIMEOUT
        ];

        // Default method is always POST
        if ($this->config->getMethod() !== self::METHOD_GET) {
            $curlOptions[CURLOPT_POST] = 1;

            if ($methodInstance->hasAttachedData()) {
                $curlOptions[CURLOPT_HTTPHEADER]  = [static::CONTENT_TYPE_MULTIPART];
                $curlOptions[CURLOPT_SAFE_UPLOAD] = 1;
            }

            $curlOptions[CURLOPT_POSTFIELDS] = $methodInstance->getPropertiesAsArray();

            $curlOptions[CURLOPT_URL] = $this->buildUrl($name);
        } else {
            $curlOptions[CURLOPT_URL] = $this->buildUrl($name, $methodInstance->getPropertiesAsString());
        }

        curl_setopt_array($this->ch, $curlOptions);

        return curl_exec($this->ch);
    }

    protected function getResponseObject($receivedData, $entityClass, $parent = null)
    {
        $response = null;

        try {
            $response = new Response($receivedData, $entityClass, $parent);
        } catch (Critical $e) {
            echo $e->getMessage();
        }

        return $response;
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
