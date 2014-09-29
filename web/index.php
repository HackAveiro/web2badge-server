<?php

use Symfony\Component\HttpFoundation\Request;

$app = require_once(__DIR__.'/../src/bootstrap.php');

$app->get('', 'HackAveiro\Web2Badge\Web\MainController::index');

$app->get('about', 'HackAveiro\Web2Badge\Web\MainController::about');

$app->get('feed', 'HackAveiro\Web2Badge\Web\MainController::feed');

$app->get('messages/get_one', 'HackAveiro\Web2Badge\Web\MessagesController::getOne');

$app->get('messages', 'HackAveiro\Web2Badge\Web\MessagesController::getAll');

$app->post('messages', 'HackAveiro\Web2Badge\Web\MessagesController::create');

$app->get('{deviceCode}', 'HackAveiro\Web2Badge\Web\MainController::form')
    ->assert('deviceCode', '^[a-zA-Z*+]{2}');

$app->post('devices/{deviceCode}/ping', 'HackAveiro\Web2Badge\Web\DevicesController::ping');

$app->get('devices', 'HackAveiro\Web2Badge\Web\DevicesController::getAll');

$app->get('devices/{deviceCode}/edit', 'HackAveiro\Web2Badge\Web\DevicesController::editForm');

Request::enableHttpMethodParameterOverride();
$app->put('devices', 'HackAveiro\Web2Badge\Web\DevicesController::update');

$app->run();