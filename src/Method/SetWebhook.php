<?php

namespace Teebot\Method;
use Teebot\Traits\File;
use Teebot\Entity\InputFile;
use Teebot\Entity\Message;

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