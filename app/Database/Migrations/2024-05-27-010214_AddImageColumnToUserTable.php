<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImageColumnToUserTable extends Migration
{
    public function up()
    {
        $fields = [
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'after' => 'email',
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'image');
    }
}
