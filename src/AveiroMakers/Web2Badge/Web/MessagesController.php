<?php

namespace AveiroMakers\Web2Badge\Web;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use AveiroMakers\Web2Badge\Util\StringCleaner;

class MessagesController
{
    protected $app;
    
    public function getOne(Application $app)
    {
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

        return $message['deviceCode'].StringCleaner::clean($message['text']);
    }

    public function getAll(Application $app)
    {
        $sql = 'SELECT * FROM messages ORDER BY timestamp DESC';
        $messages = $app['db']->fetchAll($sql);
        return $app->json($messages);
    }
    
    public function create(Application $app, Request $request)
    {
        $now = new \DateTime();

        $deviceCode = $request->get('deviceCode');
        $newMessageData = array(
            'deviceCode' => $deviceCode,
            'text' => $request->get('text'),
            'timestamp' => $now->format('Y-m-d H:i:s')
        );

        $app['db']->insert('messages', $newMessageData);
        $app['session']->set('message_sent', true);
        return $app->redirect($deviceCode);
    }
}