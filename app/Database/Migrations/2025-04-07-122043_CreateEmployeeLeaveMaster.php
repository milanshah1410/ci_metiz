<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployeeLeaveMaster extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'employee_code' => ['type' => 'VARCHAR', 'constraint' => 50],
            'leavetype' => ['type' => 'VARCHAR', 'constraint' => 100],
            'fromdate' => ['type' => 'DATE'],
            'todate' => ['type' => 'DATE'],
            'numberofDays' => ['type' => 'INT'],
            'comment' => ['type' => 'TEXT', 'null' => true],
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0, // 0 = Pending
                'comment'    => '0 = Pending, 1 = Approved, 2 = Rejected'
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('employee_leave_master');
    }

    public function down()
    {
        $this->forge->dropTable('employee_leave_master');
    }
}
