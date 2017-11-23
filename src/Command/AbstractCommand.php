<?php

declare(strict_types=1);

namespace Teebot\Command;

use Symfony\Component\Console\{
    Command\Command,
    Input\InputInterface,
    Output\OutputInterface,
    Exception\RuntimeException
};
use Teebot\ClientInterface;
use Teebot\Configuration\{
    ContainerInterface,
    Loader as ConfigLoader
};

class AbstractCommand extends Command
{
    /**
     * @var string $path Bot path
     */
    protected $path;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var ContainerInterface
     */
    protected $config;

    /**
     * @param string $path
     */
    protected function init(string $path)
    {
        $rPath = realpath($path);

        if (!is_dir($rPath) || !is_readable($rPath)) {
            throw new RuntimeException(sprintf('Bot directory with absolute path "%s" does not exist or not readable.', $path));
        }

        $configLoader = new ConfigLoader($rPath);
        $this->config = $configLoader->load();
    }

    /**
     * Executes command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');

        $this->init($path);
    }
}
