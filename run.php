<?php
/**
 * Teebot console listener. Through this script Teebot will be started as demon and will continuously
 * request an updates from Telegram's servers.
 *
 * @author Stan Drozdov <rudestan@gmail.com>
 */
define('ROOT_DIR', realpath(__DIR__));
require_once ROOT_DIR . '/vendor/autoload.php';

$client = new Teebot\Client();

$client->listen();
