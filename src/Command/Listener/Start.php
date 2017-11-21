<?php

namespace Teebot\Command\Listener;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Teebot\Client;
use Teebot\Command\AbstractCommand;

class Start extends AbstractCommand
{
    public function configure()
    {
        $this
            ->setName('listener:start')
            ->setDescription('Starts listening for updates, received from the bot')
            ->setHelp('Starts listening for updates, coming from bot started')
            ->addArgument(
                'path',
                InputArgument::REQUIRED,
                'Path to bot directory'
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $botName = $this->config->get('name');
        $output->writeln(sprintf('<fg=green;options=bold>%s</> <fg=yellow>started at %s</>', $botName, date('H:i, d.m.Y')));

        $client = new Client($this->config);
        $client->listen();
    }
}