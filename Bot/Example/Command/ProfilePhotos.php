<?php

namespace Teebot\Bot\Example\Command;

use Teebot\Command\AbstractCommand;
use Teebot\Entity\Message;
use Teebot\Entity\PhotoSize;
use Teebot\Method\GetFile;
use Teebot\Method\GetUserProfilePhotos;
use Teebot\Method\SendPhoto;
use Teebot\Response;
use Teebot\Method\SendChatAction;

class ProfilePhotos extends AbstractCommand
{
    /** @var Message */
    protected $entity;

    public function run()
    {
        $localPhotoPath = '/var/www/html/pic_profile_small.jpg';

        $result = (new GetUserProfilePhotos())
            ->setUserId($this->entity->getFrom()->getId())
            ->trigger();

        if ($result instanceof Response) {
            /** @var PhotoSize $photoWithMaxSize */
            $photoWithMaxSize = $result
                ->getFirstEntity()
                ->getPhotoWithMinFileSize();

            $result = (new GetFile())
                ->setFileId($photoWithMaxSize->getFileId())
                ->trigger();

            if ($result instanceof Response) {
                $downloadedFile = $result
                    ->getFirstEntity()
                    ->download('/var/www/html/pic_profile_small.jpg');

                if ($downloadedFile) {
                    (new SendChatAction())
                        ->setChatId($this->getChatId())
                        ->setAction(SendChatAction::ACTION_UPLOAD_PHOTO)
                        ->trigger();

                    sleep(2);

                    (new SendPhoto())
                        ->setChatId($this->getChatId())
                        ->setPhoto($localPhotoPath)
                        ->trigger();
                }
            }
        }
    }
}
