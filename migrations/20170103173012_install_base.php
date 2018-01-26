<?php

use Phinx\Db\Adapter\MysqlAdapter;

class InstallBase extends PuppetSkilledMigration
{
    public function change()
    {
        // Session
        $table = $this->table('sessions', array(
            'id' => false,
            'primary_key' => array('id')
        ));
        $table->addColumn('id', 'string', array(
            'limit' => 128,
        ))
        ->addColumn('ip_address', 'string', array(
            'limit' => 45
        ))
        ->addColumn('timestamp', 'integer', array(
            'limit' => 10
        ))
        ->addColumn('data', 'blob', array(
            'limit' => MysqlAdapter::BLOB_LONG
        ))
        ->create();

        // Settings
        $table = $this->table('settings', array(
            'id' => false,
            'primary_key' => array('name')
        ));
        $table->addColumn('name', 'string', array(
            'limit' => 255,
        ))
        ->addColumn('value', 'blob', array(
            'limit' => MysqlAdapter::BLOB_LONG
        ))
        ->addColumn('autoload', 'integer', array(
            'limit' => 1
        ))
        ->create();

        // Jobs table
        $table = $this->table('jobs');
        $table->addColumn('queue', 'string', array(
            'limit' => 255,
        ))
        ->addColumn('payload', 'blob', array(
            'limit' => MysqlAdapter::BLOB_LONG,
        ))
        ->addColumn('attempts', 'integer', array(
            'signed' => false,
        ))
        ->addColumn('reserved_at', 'integer', array(
            'signed' => false,
            'default' => null,
            'null' => true,
        ))
        ->addColumn('available_at', 'integer', array(
            'signed' => false,
        ))
        ->addColumn('created_at', 'integer', array(
            'signed' => false,
        ))
        ->addIndex(['queue', 'reserved_at'])
        ->create();
    }
}
