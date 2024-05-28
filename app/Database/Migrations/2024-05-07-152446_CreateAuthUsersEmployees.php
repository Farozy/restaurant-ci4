<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuthUsersEmployees extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'employee_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
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

        $this->forge->addForeignKey("user_id", "users", "id", 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey("employee_id", "employees", "id", 'CASCADE', 'CASCADE');

        $this->forge->createTable('users_employees', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable("users_employees");
        $this->forge->dropForeignKey('users', 'user_id');
        $this->forge->dropForeignKey('users_employees', 'employee_id');
    }
}
