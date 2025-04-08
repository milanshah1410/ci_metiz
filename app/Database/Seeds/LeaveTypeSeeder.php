<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['leaveType' => 'Casual Leave'],
            ['leaveType' => 'Sick Leave'],
            ['leaveType' => 'Earned Leave'],
        ];

        $this->db->table('leavemaster')->insertBatch($data);
    }
}
