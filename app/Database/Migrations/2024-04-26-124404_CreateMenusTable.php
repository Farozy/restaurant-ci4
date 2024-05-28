<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenusTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'name'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'category_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'stock'       => [
                'type'           => 'INTEGER',
                'constraint'     => '255'
            ],
            'cost'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'sell'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'discount'       => [
                'type'           => 'INTEGER',
                'constraint'     => '255'
            ],
            'image'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
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

        $this->forge->addForeignKey("category_id", "categories", "id", 'CASCADE', 'CASCADE');

        $this->forge->createTable('menus', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable("menus");
        $this->forge->dropForeignKey('menus', 'category_id');
    }
}
