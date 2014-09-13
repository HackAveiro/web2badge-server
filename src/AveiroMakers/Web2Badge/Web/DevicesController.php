<?php

namespace AveiroMakers\Web2Badge\Web;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

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
    
    public function editForm(Application $app, $deviceCode)
    {
        $device = $app['db']->fetchAssoc('SELECT * FROM devices WHERE code = ?', [$deviceCode]);

        if ($device === false)
        {
            return $app->abort('404', 'The device '.$deviceCode.' was not found!');
        }

        $updated = $app['session']->get('device_updated');
        $app['session']->set('device_updated', false);
        return $app['twig']->render('device_form.html', array(
            'device' => $device,
            'updated' => $updated
        ));        
    }
    
    public function update(Application $app, Request $request)
    {
        $updatedDevice = [
            'code' => $request->get('code'),
            'owner' => $request->get('owner'),
            'twitter_username' => $request->get('twitter_username')
        ];
        $deviceId = $request->get('id');
        
        $app['db']->update('devices', $updatedDevice, ['id' => $deviceId]);
        $app['session']->set('device_updated', true);
        return $app->redirect('/devices/'.$request->get('code').'/edit');
    }
            
}