<?php

namespace Teebot\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Teebot\Configuration\AbstractContainer as ConfigContainer;

class HttpClient
{
    const METHOD_GET = 'GET';

    const METHOD_POST = 'POST';

    /**
     * @var ConfigContainer $config
     */
    protected $config;

    /**
     * @var Client
     */
    protected $client;

    public function __construct(ConfigContainer $config)
    {
        $this->config = $config;
        $this->client = new Client([
            'base_uri' => $this->getBaseUri(),
            $this->config->get('timeout')
        ]);
    }

    protected function getBaseUri()
    {
        return sprintf(
            '%s/%s%s/',
            $this->config->get('url'),
            $this->config->get('bot_prefix'),
            $this->config->get('token')
        );
    }

    public function request($apiMethodName, $requestOptions = [])
    {
        $method = static::METHOD_POST;

        if (!isset($requestOptions['multipart']) && $this->config->get('method') == static::METHOD_GET) {
            $method = static::METHOD_GET;
        }

        $response = $this->client->request($method, $apiMethodName, $requestOptions);

        if ($response instanceof Response) {
            return $response->getBody()->getContents();
        }

        return null;
    }
}