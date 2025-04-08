<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCountry extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('country');
    }

    public function down()
    {
        $this->forge->dropTable('country');
    }
}
