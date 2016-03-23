<?php

/**
 * Request class that communicates with Telegram's web servers. Prepares an HTML request and instantiates
 * the Response object.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author  Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot;

use Teebot\Entity\AbstractEntity;
use Teebot\Method\AbstractMethod;
use Teebot\Exception\Critical;
use Teebot\Exception\Output;

class Request
{
    const METHOD_GET             = 'GET';

    const CONTENT_TYPE_MULTIPART = 'Content-Type:multipart/form-data';

    protected $ch;

    /**
     * @var Config $config Instance of configuration class
     */
    protected $config;

    /**
     * Constructs the Request object.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Destructs current object and closes CURL session.
     */
    public function __destruct()
    {
        if ($this->ch) {
            curl_close($this->ch);
        }
    }

    /**
     * Executes the Request to Telegram's servers and returns Response object.
     *
     * @param AbstractMethod      $method Teebot method's instance to get arguments from
     * @param null|AbstractEntity $parent Parent entity that initiated the Request
     *
     * @return null|Response
     */
    public function exec(AbstractMethod $method, $parent = null)
    {
        $entityClass = $method->getReturnEntity();
        $result      = $this->sendRequest($method);

        return $this->createResponseFromData($result, $entityClass, $parent);
    }

    /**
     * Prepares parameters that are required for sending and performs sending to Telegram's
     * servers via CURL and returns the result from CURL.
     *
     * @param AbstractMethod $methodInstance
     *
     * @return mixed
     */
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

            $curlOptions[CURLOPT_POSTFIELDS] = $methodInstance->getPropertiesArray();

            $curlOptions[CURLOPT_URL] = $this->buildUrl($name);
        } else {
            $curlOptions[CURLOPT_URL] = $this->buildUrl($name, $methodInstance->getPropertiesAsString());
        }

        curl_setopt_array($this->ch, $curlOptions);

        return curl_exec($this->ch);
    }

    /**
     * Creates the Response object from received data.
     *
     * @param string              $receivedData Received data from Telegram's servers
     * @param AbstractEntity      $entityClass  Entity that should be passed to Response constructor
     * @param null|AbstractEntity $parent       Parent entity
     *
     * @return null|Response
     */
    public function createResponseFromData($receivedData, $entityClass, $parent = null)
    {
        $response = null;

        try {
            $response = new Response($receivedData, $entityClass, $parent);
        } catch (Critical $e) {
            Output::log($e);
        }

        return $response;
    }

    /**
     * Returns url for request to Telegram's bot API
     *
     * @param string     $methodName The name of Telegram's method to query
     * @param null|array $args       Array of arguments to path to the method via GET string
     *
     * @return string
     */
    protected function buildUrl($methodName, $args = null)
    {
        $url = sprintf(
            '%s/%s%s/%s',
            $this->config->getUrl(),
            Config::BOT_PREFIX,
            $this->config->getToken(),
            $methodName
        );

        if ($args && strlen($args)) {
            $url .= '?' . $args;
        }

        return $url;
    }
}
