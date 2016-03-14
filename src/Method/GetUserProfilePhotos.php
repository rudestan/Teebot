<?php

namespace Teebot\Method;

class GetUserProfilePhotos extends AbstractMethod
{
    const NAME                = 'getUserProfilePhotos';

    const RETURN_ENTITY       = 'UserProfilePhotos';

    protected $userId;

    protected $offset;

    protected $limit;
}
