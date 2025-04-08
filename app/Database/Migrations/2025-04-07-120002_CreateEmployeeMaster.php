<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployeeMaster extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'employee_code' => ['type' => 'VARCHAR', 'constraint' => 50],
            'first_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'last_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'username' => ['type' => 'VARCHAR', 'constraint' => 50],
            'email' => ['type' => 'VARCHAR', 'constraint' => 100],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 20],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255],
            'address' => ['type' => 'TEXT'],
            'country' => ['type' => 'VARCHAR', 'constraint' => 50],
            'state' => ['type' => 'VARCHAR', 'constraint' => 50],
            'city' => ['type' => 'VARCHAR', 'constraint' => 50],
            'zip' => ['type' => 'VARCHAR', 'constraint' => 20],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('employee_master');    
    }

    public function down()
    {
        $this->forge->dropTable('employee_master');
    }
}
