#!/usr/bin/env php
<?php

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application("Web2Badge Command-Line-Interface", "0.1.0");
$application->run();