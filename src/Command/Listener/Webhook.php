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

class Webhook extends AbstractCommand
{
    /**
     * Configures the command
     */
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

    /**
     * Executes the command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $client = new Client($this->config);
        $client->webhook();
    }
}