<?php

namespace Teebot\Method;

class SendChatAction extends AbstractMethod
{
    const NAME          = 'sendChatAction';

    const RETURN_ENTITY = 'Message';

    const ACTION_TYPING = 'typing';

    const ACTION_UPLOAD_PHOTO = 'upload_photo';

    const ACTION_RECORD_VIDEO = 'record_video';

    const ACTION_UPLOAD_VIDEO = 'upload_video';

    const ACTION_RECORD_AUDIO = 'record_audio';

    const ACTION_UPLOAD_AUDIO = 'upload_audio';

    const ACTION_UPLOAD_DOCUMENT = 'upload_document';

    const ACTION_FIND_LOCATION = 'find_location';

    protected $chatId;

    protected $action;
}
