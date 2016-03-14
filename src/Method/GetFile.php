<?php

namespace Teebot\Method;

class GetFile extends AbstractMethod
{
    const NAME          = 'getFile';

    const RETURN_ENTITY = 'File';

    const FILE_SIZE_LIMIT_MB = 20;

    protected $fileId;
}
