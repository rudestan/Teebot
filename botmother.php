<?php
/**
 * Created by PhpStorm.
 * User: devstan
 * Date: 09.03.16
 * Time: 22:26
 */

class BotMother
{
    public function __construct()
    {
        $opts = getopt('c:n:t:');


        print_r($opts);
    }
}

$BotMother = new BotMother();