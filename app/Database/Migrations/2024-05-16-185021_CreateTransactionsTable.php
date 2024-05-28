<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionsTable extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'order' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'date' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'menu_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'amount' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'request' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'distribution_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'subtotal' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'pay' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'change' => [
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

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey("user_id", "users", "id", 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey("menu_id", "menus", "id", 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey("distribution_id", "distributions", "id", 'CASCADE', 'CASCADE');

        $this->forge->createTable('transactions', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable("transactions");
        $this->forge->dropForeignKey('users', 'user_id');
        $this->forge->dropForeignKey('menus', 'menu_id');
    }
}
