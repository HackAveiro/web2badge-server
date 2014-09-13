<?php

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../config/config.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_sqlite',
        'path'     => __DIR__.'/../data/web2badge.db',
    )
));

// Define the folder where fixtures are available
$app['fixtures_dir'] = __DIR__ . '/../data/';

$app->register(new Knp\Provider\ConsoleServiceProvider(), array(
    'console.name' =>"
 __          __  _    ___  ____            _            
 \ \        / / | |  |__ \|  _ \          | |           
  \ \  /\  / /__| |__   ) | |_) | __ _  __| | __ _  ___ 
   \ \/  \/ / _ \ '_ \ / /|  _ < / _` |/ _` |/ _` |/ _ \
    \  /\  /  __/ |_) / /_| |_) | (_| | (_| | (_| |  __/
     \/  \/ \___|_.__/____|____/ \__,_|\__,_|\__, |\___|
                                              __/ |     
                                             |___/      ",
    'console.version' => '0.1.0',
    'console.project_directory' => __DIR__ . '/..'
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
));

$app->register(new Silex\Provider\SessionServiceProvider());

$app['debug'] = true;

return $app;