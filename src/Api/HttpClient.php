<?php

declare(strict_types=1);

namespace Teebot\Api;

use Teebot\Configuration\ContainerInterface;
use GuzzleHttp\{
    Client as GuzzleClient,
    Psr7\Response
};

class HttpClient
{
    protected const METHOD_GET = 'GET';

    protected const METHOD_POST = 'POST';

    /**
     * @var ContainerInterface $config
     */
    protected $config;

    /**
     * @var GuzzleClient
     */
    protected $client;

    /**
     * @param ContainerInterface $config
     */
    public function __construct(ContainerInterface $config)
    {
        $this->config = $config;
        $this->client = new GuzzleClient([
            'base_uri' => $this->getBaseUri(),
            $this->config->get('timeout'),
        ]);
    }

    /**
     * Returns base API url
     *
     * @return string
     */
    protected function getBaseUri(): string
    {
        return sprintf(
            '%s/%s%s/',
            $this->config->get('url'),
            $this->config->get('bot_prefix'),
            $this->config->get('token')
        );
    }

    /**
     * Performs the request and returns the Response contents
     *
     * @param string $apiMethodName
     * @param array  $requestOptions
     *
     * @return null|string
     */
    public function request(string $apiMethodName, array $requestOptions = []): ?string
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
