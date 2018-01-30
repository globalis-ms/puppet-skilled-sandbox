<?php

use Phinx\Seed\AbstractSeed;

class Users extends AbstractSeed
{
    public function run()
    {
        $faker = Faker\Factory::create();

        // Add users
        $userAdminId = $faker->uuid;
        $userManagerId = $faker->uuid;
        $userCompanyId = $faker->uuid;
        $users = [
            [
                'id' => $userAdminId,
                'username' => 'administrator@globalis-ms.com',
                'password' => '$2y$10$A7fcNEN5Gmvns6sIXecujevtmcvPZCaTG3cNdCVWssJkkbKUUkPD.', // puppetskilled
                'first_name' => 'Michel',
                'last_name' => 'Administrator',
                'email' => 'administrator@globalis-ms.com',
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
                'id' => $userManagerId,
                'username' => 'manager@globalis-ms.com',
                'password' => '$2y$10$A7fcNEN5Gmvns6sIXecujevtmcvPZCaTG3cNdCVWssJkkbKUUkPD.', // puppetskilled
                'first_name' => 'Michel',
                'last_name' => 'Manager',
                'email' => 'manager@globalis-ms.com',
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


        // Add user roles
        $this->insert('users_roles', [
            [
                'user_id' => $userAdminId,
                'role_id' => 'administrator'
            ],
            [
                'user_id' => $userManagerId,
                'role_id' => 'manager'
            ],
            [
                'user_id' => $userCompanyId,
                'role_id' => 'user'
            ],
        ]);

        // Add user resources
        $companyId = $this->fetchRow('SELECT id FROM companies WHERE name = "GLOBALIS Media Systems"')['id'];
        $this->insert('resources', [
            [
                'user_id' => $userManagerId,
                'row_id' => $companyId,
                'resource_type' => 'App\Model\Company',
            ],
            [
                'user_id' => $userCompanyId,
                'row_id' => $companyId,
                'resource_type' => 'App\Model\Company',
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
    }
}
