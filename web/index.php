<?php

use Symfony\Component\HttpFoundation\Request;

$app = require_once(__DIR__.'/../src/bootstrap.php');

$app->get('', 'AveiroMakers\Web2Badge\Web\MainController::index');

$app->get('about', 'AveiroMakers\Web2Badge\Web\MainController::about');

$app->get('feed', 'AveiroMakers\Web2Badge\Web\MainController::feed');

$app->get('messages/get_one', 'AveiroMakers\Web2Badge\Web\MessagesController::getOne');

$app->get('messages', 'AveiroMakers\Web2Badge\Web\MessagesController::getAll');

$app->post('messages', 'AveiroMakers\Web2Badge\Web\MessagesController::create');

$app->get('{deviceCode}', 'AveiroMakers\Web2Badge\Web\MainController::form')
    ->assert('deviceCode', '^[a-zA-Z*]{2}');

$app->post('devices/{deviceCode}/ping', 'AveiroMakers\Web2Badge\Web\DevicesController::ping');

$app->get('devices', 'AveiroMakers\Web2Badge\Web\DevicesController::getAll');

$app->get('devices/{deviceCode}/edit', 'AveiroMakers\Web2Badge\Web\DevicesController::editForm');

Request::enableHttpMethodParameterOverride();
$app->put('devices', 'AveiroMakers\Web2Badge\Web\DevicesController::update');

$app->run();