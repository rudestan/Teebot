<?php
/**
 * @author Stan Drozdov <rudestan@gmail.com>
 * Teebot entrypoint
 */

define('ROOT_DIR', realpath(__DIR__));
require_once ROOT_DIR . '/vendor/autoload.php';

$listener = new Teebot\Listener();

$listener->listen();
