<?php

namespace Teebot\Command\Emulator;

use stdClass;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Teebot\Api\Entity\MessageEntity;
use Teebot\Client;
use Teebot\Command\AbstractCommand;

class Response extends AbstractCommand
{
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

    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $client = new Client($this->config);
        $json   = $input->getArgument('json');

        $client->webhook($json);
    }
}
