<?php

namespace Teebot\Command\Listener;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Teebot\Client;

class Test extends AbstractListener
{
    public function configure()
    {
        $this
            ->setName('listener:test')
            ->setDescription('Executes bot in webhook mode')
            ->setHelp('Executes bot in webhook mode')
            ->addArgument(
                'path',
                InputArgument::REQUIRED,
                'Path to bot directory'
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $r = '{"ok":true,"result":[{"update_id":56660391, "message":{"message_id":5988,"from":{"id":56293731,"first_name":"Stan","last_name":"Drozdov"},"chat":{"id":56293731,"first_name":"Stan","last_name":"Drozdov","type":"private"},"date":1486993099,"text":"/me","entities":[{"type":"bot_command","offset":0,"length":3}]}}]}';
        $client = new Client($this->config);
        $client->webhook($r);
    }
}
