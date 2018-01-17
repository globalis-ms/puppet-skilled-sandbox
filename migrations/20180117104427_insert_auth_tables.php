<?php

class InsertAuthTables extends PuppetSkilledMigration
{
    public function up()
    {
        // Roles
        $roleAdministratorId = $this->uuid();
        $roleManagerId = $this->uuid();
        $roleUserId = $this->uuid();
        $roles = [
            ['id' => $roleAdministratorId, 'name' => 'administrator'],
            ['id' => $roleManagerId, 'name' => 'manager'],
            ['id' => $roleUserId, 'name' => 'user'],
        ];
        $this->insert('roles', $roles);

        // Roles Permissions
        $insert = [
            $roleAdministratorId => [
                'backoffice',
                'frontoffice',
            ],
            $roleManagerId => [
                'backoffice.user',
                'frontoffice',
            ],
            $roleUserId => [
                'frontoffice',
            ]
        ];
        foreach ($insert as $role_id => $permissions) {
            foreach ($permissions as $permission) {
                $this->insert('roles_permissions', ['role_id' => $role_id, 'permission_name' => $permission]);
            }
        }

        // Create first company
        $companyId = $this->uuid();
        $companies = [
            [
                'id' => $companyId,
                'name' => 'GLOBALIS Media Systems',
            ],
        ];
        $this->insert('companies', $companies);

        // Create first user
        $userDevId = $this->uuid();
        $userAdminId = $this->uuid();
        $userCompanyId = $this->uuid();
        $userMultiCompanyId = $this->uuid();
        $users = [
            [
                'id' => $userAdminId,
                'username' => 'administrator@globalis-ms.com',
                'password' => '$2y$10$A7fcNEN5Gmvns6sIXecujevtmcvPZCaTG3cNdCVWssJkkbKUUkPD.', // puppetskilled
                'first_name' => 'Michel',
                'last_name' => 'Administrator',
                'email' => 'administrator@globalis-ms.com',
                'company_id' => $companyId,
                'language' => 'fr',
                'phone' => '0102030405',
                'mobile' => '0605040302',
                'address_1' => '6b rue Auguste Vitu',
                'postcode' => '75015',
                'town' => 'Paris',
                'timezone' => date_default_timezone_get(),
                'date_format' => '%d %B %Y',
                'datetime_format' => '%d %B %Y, %H:%M',
            ],
            [
                'id' => $userDevId,
                'username' => 'manager@globalis-ms.com',
                'password' => '$2y$10$A7fcNEN5Gmvns6sIXecujevtmcvPZCaTG3cNdCVWssJkkbKUUkPD.', // puppetskilled
                'first_name' => 'Michel',
                'last_name' => 'Manager',
                'email' => 'manager@globalis-ms.com',
                'company_id' => $companyId,
                'language' => 'fr',
                'phone' => '0102030405',
                'mobile' => '0605040302',
                'address_1' => '6b rue Auguste Vitu',
                'postcode' => '75015',
                'town' => 'Paris',
                'timezone' => date_default_timezone_get(),
                'date_format' => '%d %B %Y',
                'datetime_format' => '%d %B %Y, %H:%M',
            ],
            [
                'id' => $userCompanyId,
                'username' => 'user@globalis-ms.com',
                'password' => '$2y$10$A7fcNEN5Gmvns6sIXecujevtmcvPZCaTG3cNdCVWssJkkbKUUkPD.', // puppetskilled
                'first_name' => 'Michel',
                'last_name' => 'User',
                'email' => 'user@globalis-ms.com',
                'company_id' => $companyId,
                'language' => 'fr',
                'phone' => '0102030405',
                'mobile' => '0605040302',
                'address_1' => '6b rue Auguste Vitu',
                'postcode' => '75015',
                'town' => 'Paris',
                'timezone' => date_default_timezone_get(),
                'date_format' => '%d %B %Y',
                'datetime_format' => '%d %B %Y, %H:%M',
            ],
        ];
        $this->insert('users', $users);

        // Add user role
        $this->insert('users_roles', [
            [
                'user_id' => $userDevId,
                'role_id' => $roleManagerId,
            ],
            [
                'user_id' => $userAdminId,
                'role_id' => $roleAdministratorId,
            ],
            [
                'user_id' => $userCompanyId,
                'role_id' => $roleUserId,
            ],
        ]);

        $this->output->writeln('<fg=green>Admin user create</>');
        $this->output->writeln('<options=bold>login: administrator@globalis-ms.com</>');
        $this->output->writeln('<options=bold>password: puppetskilled</>');

        $this->output->writeln('<fg=green>Manager user create</>');
        $this->output->writeln('<options=bold>login: manager@globalis-ms.com</>');
        $this->output->writeln('<options=bold>password: puppetskilled</>');

        $this->output->writeln('<fg=green>Simple user create</>');
        $this->output->writeln('<options=bold>login: user@globalis-ms.com</>');
        $this->output->writeln('<options=bold>password: puppetskilled</>');

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
        $this->execute('DELETE FROM users_roles');
        $this->execute('DELETE FROM roles_permissions');
        $this->execute('DELETE FROM roles');
        $this->execute('DELETE FROM companies');
        $this->execute('DELETE FROM users');
        $this->execute('DELETE FROM settings');
    }
}
