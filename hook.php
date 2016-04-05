<?php
/**
 * An example of how to run Teebot in webhook mode.
 *
 * @author Stan Drozdov <rudestan@gmail.com>
 */

require_once realpath(__DIR__) . '/vendor/autoload.php';

$client   = new \Teebot\Client(['n' => 'Example']);
$response = $client->webhook();
