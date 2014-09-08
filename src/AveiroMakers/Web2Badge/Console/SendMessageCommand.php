<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AveiroMakers\Web2Badge\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SendMessageCommand extends \Knp\Command\Command
{
    protected function configure()
    {
        $this
            ->setName('send-message')
            ->setDescription('Sends a new message to a specific device')
            ->addArgument(
                'deviceID',
                InputArgument::REQUIRED,
                'The two-character code that identifies the target device'
            )
            ->addArgument(
                'text',
                InputArgument::REQUIRED,
                'The text to be sent to the device'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $now = new \DateTime();
        $newMessageData = array(
            'deviceID' => $input->getArgument('deviceID'),
            'text' => $input->getArgument('text'),
            'timestamp' => $now->format('Y-m-d H:i:s')
        );

        $app = $this->getSilexApplication();
        $app['db']->insert('messages', $newMessageData);

        $output->writeln('The message has been queued for delivery');
    }
}