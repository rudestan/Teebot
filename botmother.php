<?php

use Teebot\Exception\Fatal;

class BotMother
{
    protected $cliOptions = [
        'short' => 'r:b:c:t:d:h:',
        'long'  => ['run', 'bot', 'command', 'token', 'dir', 'help']
    ];

    protected $commandMethodMapper = [
        'create-bot' => ['commandBotCreate', ['b:bot', 't:token', 'd:dir']],
        'help'       => ['help', []],
    ];

    public function __construct()
    {
        $opts = getopt($this->cliOptions['short'], $this->cliOptions['long']);

        $help = $opts['h'] ?? $opts['help'] ?? null;

        if ($help || empty($opts)) {
            $this->help();

            exit;
        }

        $command = $opts['r'] ?? $opts['run'] ?? null;

        try {
            if (!$command) {
                throw new Fatal('Command not specified!');
            }

            $method = $this->getMethod($command);

            if (!$method) {
                throw new Fatal('Unknown command!');
            }

            $args = $this->getMethodArgs($method);



            call_user_func_array([$this, $method], ['1','2','3']);
        } catch (Fatal $e) {
            echo $e->getMessage();
            exit;
        }
    }

    protected function help()
    {
        echo "
Bot mother CLI utility will help you easily and quickly create Bot or Command for existing bot. Please use
the following arguments:

-r, --run [command_name] : Command name - required parameter. Could have the following values: create-bot, create-command
-b, --bot [bot_name]     : The name of the bot that you want to create
-c, --command [name]     : The name of the command that you want to create
-t, --token [value]      : Token for the bot creation
-d, --dir [dir]          : Bot's root directory (absolute path)\n\n";
    }

    protected function getMethod($command) {
        $method = $this->commandMethodMapper[$command] ?? null;

        if (!$method || !method_exists($this, $method)) {
            return null;
        }


        return $method;
    }

    protected function getMethodArgs($methodName) {

    }

    protected function commandBotCreate($botName, $token, $dir)
    {
        echo "\nCreating a new bot.\n";

        echo $botName." - ".$token." - ".$dir;
    }
}

define('ROOT_DIR', realpath(__DIR__));
require_once ROOT_DIR . '/vendor/autoload.php';

$BotMother = new BotMother();
