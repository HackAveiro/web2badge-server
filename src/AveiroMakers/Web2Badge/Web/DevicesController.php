<?php

namespace AveiroMakers\Web2Badge\Web;

use Silex\Application;

class DevicesController
{
    public function ping(Application $app, $deviceCode)
    {
        $device = $app['db']->fetchAssoc('SELECT * FROM devices WHERE code = ?',[$deviceCode]);

        if ($device === false)
        {
            return $app->abort('404', 'The device '.$deviceID.' was not found!');
        }
        
        $now = new \DateTime();
        $timestamp = $now->format('Y-m-d H:i:s');
        $deviceId = $device['id'];

        $app['db']->update('devices', ['last_seen_at' => $timestamp], ['id' => $deviceCode]);

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
    
    public function getAll(Application $app)
    {
        $sql = 'SELECT * FROM devices ORDER BY last_seen_at DESC';
        $devices = $app['db']->fetchAll($sql);
        return $app->json($devices);
    }    
}