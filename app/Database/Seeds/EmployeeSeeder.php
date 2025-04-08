<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        // Default Employee
        $this->db->table('employee_master')->insert([
            'employee_code' => 'EMP' . $faker->unique()->numerify('###'),
            'first_name'    => $faker->firstName,
            'last_name'     => $faker->lastName,
            'username'      => $faker->userName,
            'email'         => 'employee@metiz.com',
            'phone'         => $faker->phoneNumber,
            'password'      => password_hash('123456', PASSWORD_DEFAULT),
            'address'       => $faker->address,
            'country'       => $faker->country,
            'state'         => $faker->state,
            'city'          => $faker->city,
            'zip'           => $faker->postcode,
        ]);

        //Some Fake Employees
        for ($i = 0; $i < 10; $i++) {
            $data = [
                'employee_code' => 'EMP' . $faker->unique()->numerify('###'),
                'first_name'    => $faker->firstName,
                'last_name'     => $faker->lastName,
                'username'      => $faker->userName,
                'email'         => $faker->unique()->safeEmail,
                'phone'         => $faker->phoneNumber,
                'password'      => password_hash('123456', PASSWORD_DEFAULT),
                'address'       => $faker->address,
                'country'       => $faker->country,
                'state'         => $faker->state,
                'city'          => $faker->city,
                'zip'           => $faker->postcode,
            ];

            $this->db->table('employee_master')->insert($data);
        }
    }
}
