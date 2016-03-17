<?php

define('ROOT_DIR', realpath(__DIR__));
require_once ROOT_DIR . '/vendor/autoload.php';

$client = new \Teebot\Client(['n' => 'Example']);

$data = '{"ok":true,"result":[{"update_id":696861281,
"message":{"message_id":1176,"from":{"id":56293731,"first_name":"Stan","last_name":"Drozdov"},"chat":{"id":56293731,"first_name":"Stan","last_name":"Drozdov","type":"private"},"date":1458229924,"location":{"longitude":13.404440,"latitude":52.523864}}}]}';
$response = $client->webhook($data);

print_r($response);
