<?php

class InsertAuthTables extends PuppetSkilledMigration
{
    public function up()
    {
        // Roles
        $roles = [
            ['id' => 'administrator'],
            ['id' => 'manager', 'resources_support' => serialize(['\App\Service\Secure\Company'])],
            ['id' => 'user', 'resources_support' => serialize(['\App\Service\Secure\Company'])],
        ];
        $this->insert('roles', $roles);

        // Roles Permissions
        $insert = [
            'administrator' => [
                'backoffice',
                'frontoffice',
            ],
            'manager' => [
                'backoffice.user',
                'frontoffice',
            ],
            'user' => [
                'frontoffice',
            ]
        ];
        foreach ($insert as $role_id => $permissions) {
            foreach ($permissions as $permission) {
                $this->insert('roles_permissions', ['role_id' => $role_id, 'permission_name' => $permission]);
            }
        }

        // Set base settings
        $settings = [
            [
                'name' => 'authentication.expires_reset_password',
                'value' => 3600,
                'autoload' => 0
            ],
            [
                'name' => 'email.from',
                'value' => 'puppet-skilled@example.com',
                'autoload' => 1
            ],
            [
                'name' => 'email.reply_to',
                'value' => 'puppet-skilled@example.com',
                'autoload' => 1
            ],
        ];
        $this->insert('settings', $settings);
    }

    public function down()
    {
        $this->execute('DELETE FROM roles_permissions');
        $this->execute('DELETE FROM roles');
        $this->execute('DELETE FROM settings');
    }
}
