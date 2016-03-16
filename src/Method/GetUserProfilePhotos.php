<?php

namespace Teebot\Method;

use Teebot\Entity\UserProfilePhotos;

class GetUserProfilePhotos extends AbstractMethod
{
    const NAME          = 'getUserProfilePhotos';

    const RETURN_ENTITY = UserProfilePhotos::class;

    protected $user_id;

    protected $offset;

    protected $limit;

    protected $supportedProperties = [
        'user_id' => true,
        'offset'  => false,
        'limit'   => false
    ];

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     *
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param mixed $offset
     *
     * @return $this
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param mixed $limit
     *
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }
}
