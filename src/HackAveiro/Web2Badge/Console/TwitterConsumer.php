<?php

namespace HackAveiro\Web2Badge\Console;

use Symfony\Component\Console\Output\OutputInterface;

class TwitterConsumer extends \OauthPhirehose {

    /**
     * @var type Symfony\Component\Console\Output\OutputInterface
     */
    private $output;

    private $database;
    
    public function __construct($authData, $trackWords, $database, OutputInterface $output)
    {
        parent::__construct($authData['oauth_token'], $authData['oauth_secret'], \Phirehose::METHOD_FILTER);
        $this->consumerKey = $authData['consumer_key'];
        $this->consumerSecret = $authData['consumer_secret'];
        $this->output = $output;
        $this->database = $database;
        $this->setTrack($trackWords);
    }


    public function enqueueStatus($status) {
        $data = json_decode($status, true);
        if (is_array($data) && isset($data['user']['screen_name'])) {
            $text = $data['user']['screen_name'] . ': ' . urldecode($data['text']);
            $this->show($text);
            $this->createDBMessage($text);
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

    public function show($text)
    {
        if (!isset($this->output)) {
            return print $text . "\n";
        }

        if ($this->output->getVerbosity() >= OutputInterface::OUTPUT_NORMAL) {
            $this->output->writeln($text);
        }
    }
    
    public function createDBMessage($text)
    {
        $now = new \DateTime();
        $newMessageData = array(
            'deviceCode' => '**', //Let's assume all tweets are for broadcasting for now
            'text' => $text,
            'timestamp' => $now->format('Y-m-d H:i:s')
        );

        $this->database->insert('messages', $newMessageData);
    }

}
