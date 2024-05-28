<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\PermissionModel;

class AuthSeeder extends Seeder
{
    public function run()
    {
        $groups = [
            ['name' => 'admin', 'description' => 'Admin'],
            ['name' => 'cashier', 'description' => 'Cashier'],
            ['name' => 'customer', 'description' => 'Customer']
        ];

        $this->db->table('auth_groups')->insertBatch($groups);

        $permissons = [
            [
                'name' => 'read-admin',
                'description' => 'Read Admin'
            ],
            [
                'name' => 'create-admin',
                'description' => 'Create Admin'
            ],
            [
                'name' => 'edit-admin',
                'description' => 'Edit Admin'
            ],
            [
                'name' => 'delete-admin',
                'description' => 'Delete Admin'
            ]
        ];

        $this->db->table('auth_permissions')->insertBatch($permissons);

        $groupModel = new GroupModel();
        $permission = new PermissionModel();
        $permissions = $permission->findAll();

        try {
            $group = $groupModel->where('name', 'admin')->first();

            if (!$group) {
                throw new \Exception("Group 'admin' tidak ditemukan.");
            }

            foreach ($permissions as $permis) {
                $this->db->table('auth_groups_permissions')->insert([
                    'group_id' => $group->id,
                    'permission_id' => $permis->id
                ]);
            }
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
            return;
        }
    }
}
