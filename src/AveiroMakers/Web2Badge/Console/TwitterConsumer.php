<?php

namespace AveiroMakers\Web2Badge\Console;

use Symfony\Component\Console\Output\OutputInterface;

class TwitterConsumer extends \OauthPhirehose {

    /**
     * @var type Symfony\Component\Console\Output\OutputInterface
     */
    private $output;

    public function __construct($authData, $trackWords, OutputInterface $output)
    {
        parent::__construct($authData['oauth_token'], $authData['oauth_secret'], \Phirehose::METHOD_FILTER);
        $this->consumerKey = $authData['consumer_key'];
        $this->consumerSecret = $authData['consumer_secret'];
        $this->output = $output;
        $this->setTrack($trackWords);
    }


    public function enqueueStatus($status) {
        $data = json_decode($status, true);
        if (is_array($data) && isset($data['user']['screen_name'])) {
            $newMessage = [
                'username' => $data['user']['screen_name'],
                'text' => urldecode($data['text']),
                'timestamp' => $data['created_at']
            ];
            //For now, let's just print the messages to the console
            $this->write(print_r($newMessage, true));
        }
    }

    public function log($message, $level = 'notice')
    {
        if (!isset($this->output)) {
            return parent::log($message, $level);
        }

        $minVerbosityMap = [
            'error' => OutputInterface::VERBOSITY_NORMAL,
            'notice' => OutputInterface::VERBOSITY_VERBOSE,
            'info' => OutputInterface::VERBOSITY_VERY_VERBOSE
        ];

        if ($this->output->getVerbosity() >= $minVerbosityMap[$level]) {
            $this->output->writeln($message);
        }
    }

    public function write($message)
    {
        if (!isset($this->output)) {
            return print $message . "\n";
        }

        if ($this->output->getVerbosity() >= OutputInterface::OUTPUT_NORMAL) {
            $this->output->writeln($message);
        }
    }

}
