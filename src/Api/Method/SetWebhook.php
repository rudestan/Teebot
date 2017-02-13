<?php

/**
 * Class that represents Telegram's Bot-API "setWebhook" method.
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Api\Method;

use Teebot\Api\Traits\File;
use Teebot\Api\Entity\InputFile;
use Teebot\Api\Entity\Message;

class SetWebhook extends AbstractMethod
{
    use File;

    const NAME          = 'setWebhook';

    const RETURN_ENTITY = Message::class;

    protected $url;

    protected $certificate;

    protected $supportedProperties = [
        'url'         => false,
        'certificate' => false
    ];

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Removes webhook
     *
     * @return $this
     */
    public function removeHook()
    {
        return $this->setUrl('');
    }

    /**
     * @return \CURLFile|string
     */
    public function getCertificate()
    {
        return $this->certificate;
    }

    /**
     * @param string $certificate
     *
     * @return $this
     */
    public function setCertificate($certificate)
    {
        $this->certificate = (new InputFile($certificate))->getFileForUpload();

        return $this;
    }
}
