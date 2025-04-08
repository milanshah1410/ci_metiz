<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LeaveBalanceSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        $db = \Config\Database::connect();

        // Get employee codes from employee_master
        $employees = $db->table('employee_master')->select('employee_code')->get()->getResult();

        // Get leave types (e.g., 1 = Sick Leave, etc.)
        $leaveTypes = $db->table('leavemaster')->select('id')->get()->getResult();
        foreach ($employees as $employee) {
            foreach ($leaveTypes as $leaveType) {
                $data = [
                    'employeecode'       => $employee->employee_code,
                    'leavetype'          => $leaveType->id,
                    'leavebalance'       => $faker->randomFloat(2, 5, 15),
                    'creadeted_DateTime' => date('Y-m-d H:i:s'),
                ];
                $this->db->table('leavebalance')->insert($data);
            }
        }
    }
}
