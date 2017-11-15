<?php

namespace Teebot\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Exception\RuntimeException;
use Teebot\Configuration\Container;
use Teebot\Configuration\Loader as ConfigLoader;

class AbstractCommand extends Command
{
    /**
     * @var string $path Bot path
     */
    protected $path;

    protected $client;

    /**
     * @var Container
     */
    protected $config;

    protected function init($path)
    {
        $rPath = realpath($path);

        if (!is_dir($rPath) || !is_readable($rPath)) {
            throw new RuntimeException(sprintf('Bot directory with absolute path "%s" does not exist or not readable.', $path));
        }

        $configLoader = new ConfigLoader($rPath);
        $this->config = $configLoader->load();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');

        $this->init($path);
    }
}
