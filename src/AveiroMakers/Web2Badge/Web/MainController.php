<?php

namespace AveiroMakers\Web2Badge\Web;

use Silex\Application;

class MainController
{
    public function index(Application $app)
    {
        return $app['twig']->render('index.html', array(
            'team_members' => $app['team_members']
        ));        
    }
    
    public function form(Application $app, $deviceID)
    {
        $app['session']->set('my_value', 'teste');
        $team_members = $app['team_members'];

        $sent = $app['session']->get('message_sent');
        $app['session']->set('message_sent', false);
        return $app['twig']->render('form.html', array(
            'deviceID' => $deviceID,
            'target' => $team_members[$deviceID],
            'sent' => $sent
        ));
    }
}