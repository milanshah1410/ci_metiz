<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLeaveMaster extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'leaveType' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('leaveMaster');    
    }

    public function down()
    {
        $this->forge->dropTable('leaveMaster');
    }
}
