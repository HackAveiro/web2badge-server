<?php

namespace HackAveiro\Web2Badge\Web;

use Silex\Application;

class MainController
{
    public function index(Application $app)
    {
        return $app['twig']->render('index.html', array(
            'devices' => $app['db']->fetchAll('SELECT * FROM devices'),
            'tags' => explode(';',TWITTER_FILTER)
        ));        
    }

    public function about(Application $app)
    {
        return $app['twig']->render('about.html');
    }

    public function feed(Application $app)
    {
        return $app['twig']->render('feed.html', array(
            'messages' => $app['db']->fetchAll('SELECT * FROM messages ORDER BY timestamp DESC LIMIT 20')
        ));
    }


    public function form(Application $app, $deviceCode)
    {
        $device = $app['db']->fetchAssoc('SELECT * FROM devices WHERE code = ?', [$deviceCode]);

        if ($device === false)
        {
            return $app->abort('404', 'The device '.$deviceCode.' was not found!');
        }

        $sent = $app['session']->get('message_sent');
        $app['session']->set('message_sent', false);
        return $app['twig']->render('form.html', array(
            'deviceCode' => $deviceCode,
            'target' => $device['owner'],
            'sent' => $sent
        ));
    }
}