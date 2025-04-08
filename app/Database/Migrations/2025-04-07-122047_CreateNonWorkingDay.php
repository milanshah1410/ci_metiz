<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNonWorkingDay extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'date' => ['type' => 'DATE', 'unique' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('nonworkingday');    
    }

    public function down()
    {
        $this->forge->dropTable('nonworkingday');
    }
}
