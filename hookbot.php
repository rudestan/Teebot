<?php

define('ROOT_DIR', realpath(__DIR__));
require_once ROOT_DIR . '/vendor/autoload.php';

$client = new \Teebot\Client(['n' => 'Example']);
$data = '{"update_id":696861042, "message":{"message_id":881,"from":{"id":56293731,"first_name":"Stan","last_name":"Drozdov"},"chat":{"id":56293731,"first_name":"Stan","last_name":"Drozdov","type":"private"},"date":1458148546,"text":"\u0432\u044b\u0430\u044b\u0432\u0430"}}';
$client->webhook($data);