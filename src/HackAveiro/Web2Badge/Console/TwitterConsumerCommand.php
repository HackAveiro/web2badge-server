<?php

namespace HackAveiro\Web2Badge\Console;

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

        $silexApp = $this->getSilexApplication();
        $database = $silexApp['db'];

        $twitterAuth = [
            'consumer_key' => TWITTER_CONSUMER_KEY,
            'consumer_secret' => TWITTER_CONSUMER_SECRET,
            'oauth_token' => TWITTER_OAUTH_TOKEN,
            'oauth_secret' => TWITTER_OAUTH_SECRET
        ];
        $twitterFilter = explode(';',TWITTER_FILTER);
        $sc = new TwitterConsumer($twitterAuth, $twitterFilter, $database, $output);

        $sc->consume();
    }
}