<?php

namespace Teebot\Bot\Example\EntityEvent;

use Teebot\Command\AbstractEntityEvent;
use Teebot\Entity\Inline\InlineQueryResultArray;
use Teebot\Entity\Inline\InlineQueryResultPhoto;
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

        $queryId = $this->entity->getId();

        $pics = [
        ];

        $queryResultArray = new InlineQueryResultArray();

        foreach ($pics as $i => $pic) {
            $picture = (new InlineQueryResultPhoto())
                ->setId($i)
                ->setPhotoUrl($pic['i'])
                ->setThumbUrl($pic['t']);

            $queryResultArray->addEntity($picture);
        }

        (new AnswerInlineQuery())
            ->setInlineQueryId($queryId)
            ->setResults($queryResultArray->getEncodedEntities())
            ->trigger();
    }
}
