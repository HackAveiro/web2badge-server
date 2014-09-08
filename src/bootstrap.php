<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_sqlite',
        'path'     => __DIR__.'/../messages.db',
    )
));

$app->register(new Knp\Provider\ConsoleServiceProvider(), array(
    'console.name' => 'Web2Badge Command-Line-Interface',
    'console.version' => '0.1.0',
    'console.project_directory' => __DIR__ . '/..'
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
));

$app['debug'] = true;

return $app;