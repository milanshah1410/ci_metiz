<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCity extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'state_id' => ['type' => 'INT'],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('city');    
    }

    public function down()
    {
        $this->forge->dropTable('city');
    }
}
