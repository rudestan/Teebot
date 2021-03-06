<?php

namespace Teebot\Api\Entity\Inline;

use Teebot\Api\Entity\AbstractEntity;
use Teebot\Api\Entity\User;
use Teebot\Api\Entity\Message;

class CallbackQuery extends AbstractEntity
{
    const ENTITY_TYPE = 'CallbackQuery';

    /** @var string $text */
    protected $id;

    /** @var User $from */
    protected $from;

    /** @var Message $message */
    protected $message;

    /** @var string $inline_message_id */
    protected $inline_message_id;

    /** @var string $data */
    protected $data;

    protected $supportedProperties = [
        'id'                => true,
        'from'              => false,
        'message'           => false,
        'inline_message_id' => false,
        'data'              => false
    ];

    protected $builtInEntities = [
        'from'    => User::class,
        'message' => Message::class
    ];
}
