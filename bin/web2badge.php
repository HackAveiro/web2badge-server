#!/usr/bin/env php
<?php

// Bootstrap the silex application
$app = require_once __DIR__.'/../src/bootstrap.php';

// Extract the console service from the silex app
$cli = $app['console'];

// Add each cli command to the list of commands available
$cli->add(new \HackAveiro\Web2Badge\Console\SendMessageCommand());
$cli->add(new \HackAveiro\Web2Badge\Console\SetupDatabaseCommand());
$cli->add(new \HackAveiro\Web2Badge\Console\TwitterConsumerCommand());

// Parses the input and executes the appropriate command
$cli->run();