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
            return $app->abort('404', 'The device '.$deviceCode.' was not found!');
        }
        
        $now = new \DateTime();
        $timestamp = $now->format('Y-m-d H:i:s');
        $deviceId = $device['id'];

        $app['db']->update('devices', ['last_seen_at' => $timestamp], ['id' => $deviceId]);

    }
   
    public function getAll(Application $app)
    {
        $sql = 'SELECT * FROM devices ORDER BY last_seen_at DESC';
        $devices = $app['db']->fetchAll($sql);
        return $app->json($devices);
    }    
}