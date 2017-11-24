<?php

/**
 * Request class that communicates with Telegram's web servers. Prepares an HTML request and instantiates
 * the Response object.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author  Stanislav Drozdov <rudestan@gmail.com>
 */

declare(strict_types=1);

namespace Teebot\Api;

use Teebot\Api\{
    Entity\EntityInterface,
    Method\AbstractMethod,
    Method\MethodInterface
};

class Request
{
    /**
     * @var HttpClient $client
     */
    protected $httpClient;

    /**
     * Request constructor.
     *
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Executes the Request to Telegram's servers and returns Response object.
     *
     * @param MethodInterface      $method Teebot method's instance to get arguments from
     * @param null|EntityInterface $parent Parent entity that initiated the Request
     *
     * @return Response
     */
    public function exec(MethodInterface $method, EntityInterface $parent = null): Response
    {
        $entityClass = $method->getReturnEntity();
        $result      = $this->send($method);

        return $this->createResponseFromData($result, $entityClass, $parent);
    }

    /**
     * Sends the request
     *
     * @param MethodInterface $methodInstance
     *
     * @return null|string
     */
    protected function send(MethodInterface $methodInstance): ?string
    {
        $options = [
            'query' => $methodInstance->getPropertiesArray(),
        ];

        if ($methodInstance->hasAttachedData()) {
            $options = [
                'multipart' => $methodInstance->getPropertiesMultipart(),
            ];
        }

        return $this->httpClient->request($methodInstance->getName(), $options);
    }

    /**
     * Creates the Response object from received data.
     *
     * @param string               $receivedData Received data from Telegram's servers
     * @param null|string          $entityClass  Entity class name that should be passed to Response constructor
     * @param null|EntityInterface $parent       Parent entity
     *
     * @return Response
     */
    public function createResponseFromData(
        string $receivedData,
        ?string $entityClass,
        EntityInterface $parent = null
    ): Response {
        return new Response($receivedData, $entityClass, $parent);
    }
}
