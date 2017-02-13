<?php

/**
 * Request class that communicates with Telegram's web servers. Prepares an HTML request and instantiates
 * the Response object.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author  Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api;

use Teebot\Api\Entity\AbstractEntity;
use Teebot\Api\Method\AbstractMethod;
use Teebot\Api\Exception\Critical;
use Teebot\Api\Exception\Output;

class Request
{

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
        $result      = $this->send($method);

        return $this->createResponseFromData($result, $entityClass, $parent);
    }

    protected function send(AbstractMethod $methodInstance)
    {
        $client  = HttpClient::getInstance();
        $options = [
            'query' => $methodInstance->getPropertiesArray(),
        ];

        if ($methodInstance->hasAttachedData()) {
            $options = [
                'multipart' => $methodInstance->getPropertiesMultipart(),
            ];
        }

        return $client->request($methodInstance->getName(), $options);
    }

    /**
     * Creates the Response object from received data.
     *
     * @param string              $receivedData Received data from Telegram's servers
     * @param string              $entityClass  Entity class name that should be passed to Response constructor
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
}
