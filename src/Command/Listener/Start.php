<?php

declare(strict_types=1);

namespace Teebot\Command\Listener;

use Symfony\Component\Console\Input\{
    InputArgument,
    InputInterface
};
use Symfony\Component\Console\Output\OutputInterface;
use Teebot\{
    Client,
    Command\AbstractCommand
};

class Start extends AbstractCommand
{
    /**
     * Configures the command
     */
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

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $botName = $this->config->get('name');
        $output->writeln(sprintf('<fg=green;options=bold>%s</> <fg=yellow>started at %s</>', $botName, date('H:i, d.m.Y')));

        $client = new Client($this->config);
        $client->listen();
    }
}