<?php

namespace Teebot\Command\Listener;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Teebot\Client;

class Webhook extends AbstractListener
{
    public function configure()
    {
        $this
            ->setName('listener:webhook')
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

        $client = new Client($this->config);
        $client->webhook();
    }
}