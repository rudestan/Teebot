<?php

namespace Teebot\Entity;

class ForceReply extends AbstractEntity {

    protected $force_reply = true;

    protected $selective;

    /**
     * @param boolean $force_reply
     */
    public function setForceReply($force_reply)
    {
        $this->force_reply = true;
    }
}
