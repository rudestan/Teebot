<?php

return [
    'name' => 'Example',
    'token' => '<BOT_TOKEN>',
    'url' => 'https://api.telegram.org',
    'file_url' => 'https://api.telegram.org/file/bot',
    'timeout' => 3,
    'events' => [
        [
            'command' => 'Me',
            'type' => 'Command',
            'class' => 'Teebot\Bot\Example\Command\Me'
        ]
    ]
];