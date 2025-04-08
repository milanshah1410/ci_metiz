<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateState extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'country_id' => ['type' => 'INT'],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('state');    
    }

    public function down()
    {
        $this->forge->dropTable('state');
    }
}
