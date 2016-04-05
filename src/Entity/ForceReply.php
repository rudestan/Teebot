<?php

namespace Teebot\Entity;

class ForceReply extends AbstractEntity {

    protected $force_reply = true;

    protected $selective;

    /**
     * Always set force_reply flag to true
     */
    public function setForceReply()
    {
        $this->force_reply = true;
    }

    /**
     * @return boolean
     */
    public function getForceReply()
    {
        return $this->force_reply;
    }

    /**
     * @param mixed $selective
     *
     * @return $this
     */
    public function setSelective($selective)
    {
        $this->selective = $selective;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSelective()
    {
        return $this->selective;
    }
}
