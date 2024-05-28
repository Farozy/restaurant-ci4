<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'color' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'background' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey("user_id", "users", "id", 'CASCADE', 'CASCADE');

        $this->forge->createTable('events', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable("events");
        $this->forge->dropForeignKey('events', 'user_id');
    }
}
