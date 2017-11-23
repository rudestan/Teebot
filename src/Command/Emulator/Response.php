<?php

declare(strict_types=1);

namespace Teebot\Command\Emulator;

use Symfony\Component\Console\Input\{
    InputArgument,
    InputInterface
};
use Symfony\Component\Console\Output\OutputInterface;
use Teebot\{
    Client,
    Command\AbstractCommand
};

class Response extends AbstractCommand
{
    /**
     * Configures the command
     */
    public function configure()
    {
        $this
            ->setName('emulator:response')
            ->setDescription('Triggers Webhook with provided JSON string')
            ->setHelp('Triggers Webhook with provided JSON string')
            ->addArgument(
                'path',
                InputArgument::REQUIRED,
                'Path to bot directory'
            )
            ->addArgument(
                'json',
                InputArgument::REQUIRED,
                'Json string'
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
        $json   = $input->getArgument('json');

        $client->webhook($json);
    }
}
