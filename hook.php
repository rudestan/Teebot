<?php

define('ROOT_DIR', realpath(__DIR__));
require_once ROOT_DIR . '/vendor/autoload.php';

$client = new \Teebot\Client(['n' => 'Example']);
$data = '{"ok":true,"result":[{"update_id":696861705,
"message":{"message_id":1600,"from":{"id":56293731,"first_name":"Stan","last_name":"Drozdov"},"chat":{"id":56293731,"first_name":"Stan","last_name":"Drozdov","type":"private"},"date":1458595322,"text":"\/profilephotos"}}]}';
$response = $client->webhook($data);
