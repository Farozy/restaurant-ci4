<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventDatesTable extends Migration
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
            'start' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'event_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'end' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
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
        $this->forge->addForeignKey("event_id", "events", "id", 'CASCADE', 'CASCADE');

        $this->forge->createTable('event_dates', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable("event_dates");
        $this->forge->dropForeignKey('users', 'user_id');
        $this->forge->dropForeignKey('events', 'event_id');
    }
}
