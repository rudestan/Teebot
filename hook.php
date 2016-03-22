<?php
/**
 * An example of how to run Teebot in webhook mode.
 *
 * @author Stan Drozdov <rudestan@gmail.com>
 */
define('ROOT_DIR', realpath(__DIR__));
require_once ROOT_DIR . '/vendor/autoload.php';

$client   = new \Teebot\Client(['n' => 'Example']);
$response = $client->webhook();
