<?php

namespace Teebot\Bot\Example\EntityEvent;

use Teebot\Command\AbstractEntityEvent;
use Teebot\Entity\Inline\InlineQueryResultArray;
use Teebot\Entity\Inline\InlineQueryResultArticle;
use Teebot\Entity\Inline\InlineQueryResultGif;
use Teebot\Entity\Inline\InlineQueryResultMpeg4Gif;
use Teebot\Entity\Inline\InlineQueryResultPhoto;
use Teebot\Entity\Inline\InlineQueryResultVideo;
use Teebot\Method\AnswerInlineQuery;

class InlineQuery extends AbstractEntityEvent
{
    /** @var \Teebot\Entity\Inline\InlineQuery $entity */
    protected $entity;

    public function run()
    {
        if (empty($this->entity->getQuery())) {
            return;
        }

        $query = strtolower($this->entity->getQuery());

        $this->testMpeg4Gif();

        return;
    }

    protected function testMpeg4Gif()
    {
        $queryId = $this->entity->getId();

        $resultVideo = (new InlineQueryResultMpeg4Gif())
            ->setMpeg4Url('http://storage.akamai.coub.com/get/bucket:12.21/p/coub/simple/cw_file/0f18dd89e09/2d8508ac124aa6290da0e/muted_mp4_med_size_1409439085_muted_med.mp4')
            ->setMpeg4Width(335)
            ->setMpeg4Height(188)
            ->setId(1);

        $queryResultArray = (new InlineQueryResultArray())
            ->addEntity($resultVideo);


        (new AnswerInlineQuery())
            ->setInlineQueryId($queryId)
            ->setResults($queryResultArray->getEncodedEntities())
            ->trigger();
    }

    protected function testVideo()
    {
        $queryId = $this->entity->getId();

        $resultVideo = (new InlineQueryResultVideo())
            ->setVideoUrl('https://www.youtube.com/embed/R3my_mHRoto')
            ->setMimeTypeHTML()
            ->setTitle('Chick with tits')
            ->setMessageText('Chick with tits!')
            ->setThumbUrl('https://img-fotki.yandex.ru/get/6506/25232117.5/0_6c424_14b6ee9d_S.jpg')
            ->setId(1);

        $queryResultArray = (new InlineQueryResultArray())
            ->addEntity($resultVideo);


        (new AnswerInlineQuery())
            ->setInlineQueryId($queryId)
            ->setResults($queryResultArray->getEncodedEntities())
            ->trigger();
    }

    protected function testArticleAndPhoto()
    {
        $queryId = $this->entity->getId();

        $resultArticle = (new InlineQueryResultArticle())
            ->setTitle('Hello article!')
            ->setMessageText('This is an article!')
            ->setId(1);

        $picture = (new InlineQueryResultPhoto())
            ->setPhotoUrl('https://img-fotki.yandex.ru/get/6506/25232117.5/0_6c424_14b6ee9d_M.jpg')
            ->setThumbUrl('https://img-fotki.yandex.ru/get/6506/25232117.5/0_6c424_14b6ee9d_S.jpg')
            ->setPhotoHeight(100)
            ->setPhotoWidth(200)
            ->setId(2);        

        $queryResultArray = (new InlineQueryResultArray())
            ->addEntity($resultArticle)
            ->addEntity($picture);


        (new AnswerInlineQuery())
            ->setInlineQueryId($queryId)
            ->setResults($queryResultArray->getEncodedEntities())
            ->trigger();
    }

    protected function testPhoto() {
        $queryId = $this->entity->getId();

        $pics = [
            [
                'i' => 'https://img-fotki.yandex.ru/get/6506/25232117.5/0_6c424_14b6ee9d_M.jpg',
                't' => 'https://img-fotki.yandex.ru/get/6506/25232117.5/0_6c424_14b6ee9d_S.jpg'
            ],
            [
                'i' => 'https://img-fotki.yandex.ru/get/6504/25232117.5/0_6c420_286b4fd6_M.jpg',
                't' => 'https://img-fotki.yandex.ru/get/6504/25232117.5/0_6c420_286b4fd6_S.jpg'
            ],
            [
                'i' => 'https://img-fotki.yandex.ru/get/6509/25232117.5/0_6c41e_ba7c6389_M.jpg',
                't' => 'https://img-fotki.yandex.ru/get/6509/25232117.5/0_6c41e_ba7c6389_S.jpg'
            ]
        ];

        $queryResultArray = new InlineQueryResultArray();

        $i = 0;
        foreach ($pics as $pic) {
            $i++;
            $picture = (new InlineQueryResultPhoto())
                ->setId($i)
                ->setPhotoUrl($pic['i'])
                ->setThumbUrl($pic['t'])
                ->setPhotoHeight(100)
                ->setPhotoWidth(200);

            $queryResultArray->addEntity($picture);
        }

        (new AnswerInlineQuery())
            ->setInlineQueryId($queryId)
            ->setResults($queryResultArray->getEncodedEntities())
            ->trigger();
    }

    protected function testGifs()
    {
        $queryId = $this->entity->getId();

        $gifs = ['http://vignette2.wikia.nocookie.net/halofanon/images/6/66/Mudkip_Dancing_small.gif'];

        $queryResultArray = new InlineQueryResultArray();
        $i = 0;
        foreach ($gifs as $gif) {
            $i++;
            $gifResult = (new InlineQueryResultGif())
                ->setId($i)
                ->setGifUrl($gif)
                ->setGifWidth(100)
                ->setGifHeight(100)
                ->setThumbUrl($gif);

            $queryResultArray->addEntity($gifResult);

            $i++;
            $gifResult = (new InlineQueryResultGif())
                ->setId($i)
                ->setGifUrl($gif)
                ->setGifWidth(100)
                ->setGifHeight(100)
                ->setThumbUrl($gif);

            $queryResultArray->addEntity($gifResult);

            $i++;
            $gifResult = (new InlineQueryResultGif())
                ->setId($i)
                ->setGifUrl($gif)
                ->setGifWidth(100)
                ->setGifHeight(100)
                ->setThumbUrl($gif);

            $queryResultArray->addEntity($gifResult);
        }

        (new AnswerInlineQuery())
            ->setInlineQueryId($queryId)
            ->setResults($queryResultArray->getEncodedEntities())
            ->trigger();
    }
}
