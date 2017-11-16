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

class Message extends AbstractCommand
{
    public function configure()
    {
        $this
            ->setName('emulator:message')
            ->setDescription('Builds a received message from provided text or raw json and passes it to Webhook')
            ->setHelp('Triggers Webhook with prebuilt message')
            ->addArgument(
                'path',
                InputArgument::REQUIRED,
                'Path to bot directory'
            )
            ->addArgument(
                'message',
                InputArgument::REQUIRED,
                'Message text'
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $client      = new Client($this->config);
        $messageText = $input->getArgument('message');
        $message     = $this->buildMessage($messageText);

        $client->webhook($message);
    }

    protected function buildMessage($messageText)
    {
        $entity         = new stdClass();
        $entity->offset = 0;
        $entity->length = strlen($messageText);
        $entity->type   = MessageEntity::TYPE_BOT_COMMAND;

        $message           = new stdClass();
        $message->text     = $messageText;
        $message->entities = [
            $entity,
        ];

        $result          = new stdClass();
        $result->message = $message;

        $data         = new stdClass();
        $data->ok     = true;
        $data->result = [
            $result,
        ];

        return json_encode($data);
    }
}
