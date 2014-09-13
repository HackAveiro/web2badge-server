<?php

namespace AveiroMakers\Web2Badge\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TwitterConsumerCommand extends \Knp\Command\Command
{
    protected function configure()
    {
        $this
            ->setName('twitter-consumer')
            ->setDescription('Connects to twitter\'s streaming API to detect messages to send to the badges');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Started Web2Badge\'s Twitter Consumer');

        $sc = new TwitterConsumer(TWITTER_OAUTH_TOKEN, TWITTER_OAUTH_SECRET, \Phirehose::METHOD_FILTER);
        $sc->setTrack(explode(';',TWITTER_FILTER));
        $sc->setOutputInterface($output);

        $sc->consume();
    }
}