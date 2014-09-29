<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace HackAveiro\Web2Badge\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SetupDatabaseCommand extends \Knp\Command\Command
{
    protected function configure()
    {
        $this
            ->setName('setup-database')
            ->setDescription('Configures the database with the appropriate structure');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $db = $app['db'];
        $schema = $db->getSchemaManager()->createSchema();
        
        // Prepare the table to store messages
        $messagesTable = $schema->createTable('messages');
        $messagesTable->addColumn('id', 'integer', array('unsigned' => true));
        $messagesTable->addColumn('deviceCode', 'string', array('length' => 2));
        $messagesTable->addColumn('text', 'string', array('length' => 140));
        $messagesTable->addColumn('sent', 'boolean', array('default' => false));
        $messagesTable->addColumn('timestamp', 'datetime');
        $messagesTable->setPrimaryKey(['id']);

        
        // Prepare the table to store devices
        $devicesTable = $schema->createTable('devices');
        $devicesTable->addColumn('id', 'integer', array('unsigned' => true));
        $devicesTable->addColumn('code', 'string', array('length' => 2));
        $devicesTable->addColumn('owner', 'string');
        $devicesTable->addColumn('last_seen_at', 'datetime', array('notnull' => false));
        $devicesTable->addColumn('twitter_username', 'text', array('notnull' => false));
        $devicesTable->setPrimaryKey(['id']);
        $devicesTable->addUniqueIndex(['code']);
        
        $queries = $schema->toSql($db->getDatabasePlatform());
        foreach($queries as $query)
        {
            $db->executeQuery($query);   
        }
        $output->writeLn('Database schema was successfully prepared!');
        
        $output->writeLn('Importing devices');

        $devices = include($app['fixtures_dir'].'/devices.php');
        foreach ($devices as $device) {
            $db->insert('devices', $device);   
        }

        $output->writeLn('Devices imported!');
    }
}