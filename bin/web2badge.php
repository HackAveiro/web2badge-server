#!/usr/bin/env php
<?php

$app = require_once __DIR__.'/../src/bootstrap.php';

$cli = $app['console'];
$cli->add(new \AveiroMakers\Web2Badge\Console\SendMessageCommand());
$cli->add(new \AveiroMakers\Web2Badge\Console\SetupDatabaseCommand());
$cli->add(new \AveiroMakers\Web2Badge\Console\TwitterConsumerCommand());
$cli->run();