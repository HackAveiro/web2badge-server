<?php

use Symfony\Component\HttpFoundation\Request;

$app = require_once(__DIR__.'/../src/bootstrap.php');

$app->get('', function() use ($app) { 
    return $app['twig']->render('index.html');
}); 

$app->get('messages/get_one', function() use ($app) {
    $sql = 'SELECT * FROM messages WHERE sent = ? ORDER BY timestamp ASC';
    $message = $app['db']->fetchAssoc($sql, array(0));
    if ($message === false)
    {
        return "EMPTY";
    }
    else
    {
        $sql = "UPDATE messages SET sent = ? WHERE id = ?";
        $app['db']->executeUpdate($sql, array(1, $message['id']));
    }
    
    return $message['deviceID'].$message['text'];
});

$app->post('messages', function(Request $request) use ($app) {
    $now = new \DateTime();
    $newMessageData = array(
        'deviceID' => $request->get('deviceID'),
        'text' => $request->get('text'),
        'timestamp' => $now->format('Y-m-d H:i:s')
    );

    $app['db']->insert('messages', $newMessageData);
    return 'OK';
});

$app->run();