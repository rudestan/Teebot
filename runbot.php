<?php
/**
 * @author Stan Drozdov <rudestan@gmail.com>
 * Teebot entrypoint
 */

define('ROOT_DIR', realpath(__DIR__));
require_once ROOT_DIR . '/vendor/autoload.php';

$client = new Teebot\Client();

$client->listen();
