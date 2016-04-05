<?php

/**
 * Exception output class
 *
 * @package Teebot (Telegram bot framework)
 *
 * @author Stanislav Drozdov <rudestan@gmail.com>
 */

namespace Teebot\Exception;

use Teebot\Command\Executor;
use Teebot\Config;

class Output
{
    public static function log($e)
    {
        $logFile = null;

        if (Executor::getInstance()->getConfig() instanceof Config) {
            $logFile = Executor::getInstance()->getConfig()->getLogFile();
        }

        $type    = "\\Exception";
        $pattern = "%s";

        if ($e instanceof AbstractException) {
            $type    = $e->getType();
            $pattern = $e->getColorMessagePattern();
        }

        if ($logFile !== null && is_writable($logFile)) {
            $fh = fopen($logFile, "a");

            $logString = sprintf(
                "[%s] [%s] %s\n",
                date("H:i:s d.m.Y"),
                $type,
                $e->getMessage()
            );
            fwrite($fh, $logString);
            fclose($fh);
        } else {
            echo sprintf(
                $pattern,
                $e->getMessage()
            ). "\n";
        }

        if ($e instanceof Fatal) {
            exit();
        }
    }
}