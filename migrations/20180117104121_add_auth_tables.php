<?php

use Phinx\Db\Adapter\MysqlAdapter;

class AddAuthTables extends PuppetSkilledMigration
{
    public function change()
    {
        // Companies table
        $table = $this->table('companies', array(
            'id' => false,
            'primary_key' => array('id')
        ));
        $table->addColumn('id', 'string', array(
            'limit' => 36,
        ))
        ->addColumn('name', 'string', array(
            'limit' => 255,
        ))
        ->addColumn('created_at', 'datetime', array(
            'default' => 'CURRENT_TIMESTAMP(6)',
            'limit' => 6,
        ))
        ->addColumn('updated_at', 'datetime', array(
            'default' => 'CURRENT_TIMESTAMP(6)',
            'limit' => 6,
        ))
        ->addColumn('deleted_at', 'datetime', array(
            'default' => null,
            'null' => true,
            'limit' => 6,
        ))
        ->addIndex('deleted_at')
        ->create();

        // Users table
        $table = $this->table('users', array(
            'id' => false,
            'primary_key' => array('id')
        ));
        $table->addColumn('id', 'string', array(
            'limit' => 36,
        ))
        ->addColumn('username', 'string', array(
            'limit' => 255,
        ))
        ->addColumn('password', 'string', array(
            'limit' => 255,
            'default' => null,
            'null' => true,
        ))
        ->addColumn('first_name', 'string', array(
            'limit' => 255,
        ))
        ->addColumn('last_name', 'string', array(
            'limit' => 255,
        ))
        ->addColumn('email', 'string', array(
            'limit' => 255,
        ))
        ->addColumn('company_id', 'string', array(
            'limit' => 36,
        ))
        ->addColumn('phone', 'string', array(
            'limit' => 10,
        ))
        ->addColumn('mobile', 'string', array(
            'limit' => 10,
        ))
        ->addColumn('address_1', 'string', array(
            'limit' => 38
        ))
        ->addColumn('address_2', 'string', array(
            'limit' => 38,
            'default' => null,
            'null' => true,
        ))
        ->addColumn('town', 'string', array(
            'limit' => 255
        ))
        ->addColumn('postcode', 'string', array(
            'limit' => 10
        ))
        ->addColumn('language', 'string', [
            'limit' => 5,
        ])
        ->addColumn('timezone', 'string', array(
            'limit' => 255,
        ))
        ->addColumn('date_format', 'string', array(
            'limit' => 30,
        ))
        ->addColumn('datetime_format', 'string', array(
            'limit' => 30,
        ))
        ->addColumn('active', 'integer', array(
            'limit' => 1,
            'default' => '1'
        ))
        ->addColumn('created_at', 'datetime', array(
            'default' => 'CURRENT_TIMESTAMP(6)',
            'limit' => 6,
        ))
        ->addColumn('updated_at', 'datetime', array(
            'default' => 'CURRENT_TIMESTAMP(6)',
            'limit' => 6,
        ))
        ->addColumn('deleted_at', 'datetime', array(
            'default' => null,
            'null' => true,
            'limit' => 6,
        ))
        ->addIndex(['username', 'deleted_at'])
        ->addIndex('deleted_at')
        ->addForeignKey('company_id', 'companies', 'id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
        ->create();

        // Roles table
        $table = $this->table('roles', array(
            'id' => false,
            'primary_key' => array('id')
        ));
        $table->addColumn('id', 'string', array(
            'limit' => 36,
        ))
        ->addColumn('name', 'string', array(
            'limit' => 255,
        ))
        ->addColumn('resources_support', 'blob', array(
            'limit' => MysqlAdapter::BLOB_LONG,
            'null' => true,
            'default' => null
        ))
        ->addColumn('created_at', 'datetime', array(
            'default' => 'CURRENT_TIMESTAMP(6)',
            'limit' => 6,
        ))
        ->addColumn('updated_at', 'datetime', array(
            'default' => 'CURRENT_TIMESTAMP(6)',
            'limit' => 6,
        ))
        ->addColumn('deleted_at', 'datetime', array(
            'default' => null,
            'null' => true,
            'limit' => 6,
        ))
        ->addIndex('name')
        ->addIndex('deleted_at')
        ->create();

        // User has Roles table
        $table = $this->table('users_roles');
        $table->addColumn('user_id', 'string', array(
            'limit' => 36,
        ))
        ->addColumn('role_id', 'string', array(
            'limit' => 36,
        ))
        ->addIndex(['user_id', 'role_id'],  ['unique' => true])
        ->addForeignKey('user_id', 'users', 'id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
        ->addForeignKey('role_id', 'roles', 'id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
        ->create();

        // Role permissions
        $table = $this->table('roles_permissions', array(
            'id' => false,
            'primary_key' => array('role_id', 'permission_name')
        ));
        $table->addColumn('role_id', 'string', array(
            'limit' => 36,
        ))
        ->addColumn('permission_name', 'string', array(
            'limit' => 255
        ))
        ->addForeignKey('role_id', 'roles', 'id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
        ->create();

        // Revisions table
        $table = $this->table('revisions');
        $table->addColumn('action', 'string', array(
            'limit' => 255,
        ))
        ->addColumn('table_name', 'string', array(
            'limit' => 255,
        ))
        ->addColumn('row_id', 'string', array(
            'limit' => 255,
        ))
        ->addColumn('revisionable_type', 'string', array(
            'limit' => 255,
        ))
        ->addColumn('old', 'blob', array(
            'limit' => MysqlAdapter::BLOB_LONG,
            'default' => null,
            'null' => true,
        ))
        ->addColumn('new', 'blob', array(
            'limit' => MysqlAdapter::BLOB_LONG,
            'default' => null,
            'null' => true,
        ))
        ->addColumn('user', 'blob', array(
            'limit' => MysqlAdapter::BLOB_LONG,
            'default' => null,
            'null' => true,
        ))
        ->addColumn('user_id', 'string', array(
            'limit' => 36,
            'default' => null,
            'null' => true,
        ))
        ->addColumn('ip', 'string', array(
            'limit' => 255,
            'default' => null,
            'null' => true,
        ))
        ->addColumn('ip_forwarded', 'string', array(
            'limit' => 255,
            'default' => null,
            'null' => true,
        ))
        ->addColumn('created_at', 'datetime', array(
            'default' => 'CURRENT_TIMESTAMP(6)',
            'limit' => 6,
        ))
        ->addIndex(['table_name', 'row_id'])
        ->addForeignKey('user_id', 'users', 'id', array('delete'=> 'SET_NULL', 'update'=> 'CASCADE'))
        ->create();

        // Locks
        $table = $this->table('locks');
        $table->addColumn('lockable_type', 'string', array(
            'limit' => 255,
        ))
        ->addColumn('row_id', 'string', array(
            'limit' => 255,
        ))

        ->addColumn('user_id', 'string', array(
            'limit' => 36,
            'default' => null,
            'null' => true,
        ))
        ->addColumn('expired_at', 'datetime', array(
            'default' => null,
            'null' => true,
        ))
        ->addColumn('created_at', 'datetime', array(
            'default' => 'CURRENT_TIMESTAMP'
        ))
        ->addIndex(['lockable_type', 'row_id'])
        ->addForeignKey('user_id', 'users', 'id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
        ->create();

        // Reset tokens
        $table = $this->table('reset_tokens', array(
            'id' => false,
            'primary_key' => array('token')
        ))
        ->addColumn('token', 'string', array(
            'limit' => 40,
        ))
        ->addColumn('user_id', 'string', array(
            'limit' => 36,
        ))
        ->addColumn('created_at', 'datetime', array(
            'default' => 'CURRENT_TIMESTAMP'
        ))
        ->addForeignKey('user_id', 'users', 'id', array('delete'=> 'CASCADE', 'update'=> 'CASCADE'))
        ->create();
    }
}
