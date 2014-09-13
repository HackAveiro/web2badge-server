<?php

use Symfony\Component\HttpFoundation\Request;

$app = require_once(__DIR__.'/../src/bootstrap.php');

$app['team_members'] = array(
  '**' => 'everyone',
  'AF' => 'André Esteves',
  'DG' => 'Diogo Gomes',
  'FM' => 'Francisco Mendes',
  'JS' => 'Joaquim Santos',
  'LF' => 'Luís Faceira',
  'MG' => 'Marcos Gomes',
  'RL' => 'Ricardo Lameiro'
);

$app->get('', 'AveiroMakers\Web2Badge\Web\MainController::index');

$app->get('messages/get_one', 'AveiroMakers\Web2Badge\Web\MessagesController::getOneAction');

$app->get('messages', 'AveiroMakers\Web2Badge\Web\MessagesController::getAll');

$app->post('messages', 'AveiroMakers\Web2Badge\Web\MessagesController::create');

$app->get('{deviceID}', 'AveiroMakers\Web2Badge\Web\MainController::form')
    ->assert('deviceID', '^[a-zA-Z*]{2}|all');

$app->run();