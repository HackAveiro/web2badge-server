<?php

use Symfony\Component\HttpFoundation\Request;

$app = require_once(__DIR__.'/../src/bootstrap.php');

$app->get('', 'AveiroMakers\Web2Badge\Web\MainController::index');

$app->get('messages/get_one', 'AveiroMakers\Web2Badge\Web\MessagesController::getOneAction');

$app->get('messages', 'AveiroMakers\Web2Badge\Web\MessagesController::getAll');

$app->post('messages', 'AveiroMakers\Web2Badge\Web\MessagesController::create');

$app->get('{deviceCode}', 'AveiroMakers\Web2Badge\Web\MainController::form')
    ->assert('deviceCode', '^[a-zA-Z*]{2}|all');

$app->post('devices/{deviceCode}/ping', 'AveiroMakers\Web2Badge\Web\DevicesController::ping');

$app->get('devices', 'AveiroMakers\Web2Badge\Web\DevicesController::getAll');

$app->run();