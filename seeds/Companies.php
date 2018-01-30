<?php

use Phinx\Seed\AbstractSeed;

class Companies extends AbstractSeed
{
    public function run()
    {
        $faker = Faker\Factory::create();
        $companyId = $faker->uuid;
        $companies = [
            [
                'id' => $companyId,
                'name' => 'GLOBALIS Media Systems',
            ],
        ];
        $this->insert('companies', $companies);
    }
}
