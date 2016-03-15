<?php

namespace Teebot;

use Teebot\Method\AbstractMethod;
use Teebot\Exception\Critical;

class Request
{
    const METHOD_GET = 'GET';

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
        $name = $methodInstance->getName();

        if (!$this->ch) {
            $this->ch = curl_init();
        }

        // Default method is always POST
        if ($this->config->getMethod() !== self::METHOD_GET) {
            curl_setopt($this->ch, CURLOPT_POST, 1);

            $fields = $methodInstance->getPropertiesAsArray();

/*            if ($methodInstance::HAS_BINARY_DATA) {
                curl_setopt($this->ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
                curl_setopt($this->ch, CURLOPT_SAFE_UPLOAD, 1);
                $t = new \CURLFile("/var/www/html/1.jpg");
                $fields['photo'] = $t;
            }*/

            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $fields);

            $url = $this->buildUrl($name);
        } else {
            $url = $this->buildUrl($name, $methodInstance->getPropertiesAsString());
        }

        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, Config::DEFAULT_TIMEOUT);

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
