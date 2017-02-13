<?php

namespace Teebot\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Teebot\Api\Traits\ConfigAware;

class HttpClient
{
    use ConfigAware;

    const METHOD_GET = 'GET';

    const METHOD_POST = 'POST';

    /**
     * @var HttpClient
     */
    protected static $instance;

    /**
     * @var Client
     */
    protected $client;

    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function init()
    {
        $this->client = new Client([
            'base_uri' => $this->getBaseUri(),
            $this->getConfigValue('timeout')
        ]);
    }

    protected function getBaseUri()
    {
        return sprintf(
            '%s/%s%s/',
            $this->getConfigValue('url'),
            $this->getConfigValue('bot_prefix'),
            $this->getConfigValue('token')
        );
    }

    public function request($apiMethodName, $requestOptions = [])
    {
        $method = static::METHOD_POST;

        if (!isset($requestOptions['multipart']) && $this->getConfigValue('method') == static::METHOD_GET) {
            $method = static::METHOD_GET;
        }

        $response = $this->client->request($method, $apiMethodName, $requestOptions);

        if ($response instanceof Response) {
            return $response->getBody()->getContents();
        }

        return null;
    }
}