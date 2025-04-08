<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('EmployeeSeeder');
        $this->call('LeaveTypeSeeder');
        $this->call('LeaveBalanceSeeder');
        $this->call('LocationSeeder');
    }
}
