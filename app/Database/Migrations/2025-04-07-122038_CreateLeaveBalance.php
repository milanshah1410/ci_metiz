<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLeaveBalanceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'employeecode' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'leavetype' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'leavebalance' => [
                'type'       => 'FLOAT',
                'constraint' => '10,2',
                'default'    => 0,
            ],
            'creadeted_DateTime' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('leavetype', 'leavMaster', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('leavebalance');
    }

    public function down()
    {
        $this->forge->dropTable('leavebalance');
    }
}