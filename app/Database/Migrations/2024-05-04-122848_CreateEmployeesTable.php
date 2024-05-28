<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployeesTable extends Migration
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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'gender' => [
                'type' => 'ENUM',
                'constraint' => ['male', 'female']
            ],
            'date_of_birth' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'place_of_birth' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['1', '0'],
                'default' => '1'
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

        $this->forge->addKey('id', TRUE);

        $this->forge->createTable('employees', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable("employees");
    }
}
