<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\PermissionModel;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'email' => 'admin@email.com',
                'image' => 'default.png',
                'password_hash' => Password::hash('admin'),
                'activate_hash' => bin2hex(random_bytes(16)),
                'active' => 1,
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ]
        ];

        $this->db->table('users')->insertBatch($data);

        $users = new UserModel();
        $groups = new GroupModel();
        $permissions = new PermissionModel();
        $groupAdmin = $groups->where('name', 'admin')->first();
        $permission = $permissions->findAll();

        try {
            $user = $users->where('username', 'admin')->first();

            if (!$groupAdmin) throw new \Exception("Group 'admin' tidak ditemukan.");

            $this->db->table('auth_groups_users')->insert([
                'group_id' => $groupAdmin->id,
                'user_id' => $user->id
            ]);

            foreach ($permission as $permis) {
                $this->db->table('auth_users_permissions')->insert([
                    'user_id' => $user->id,
                    'permission_id' => $permis->id
                ]);
            }
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
            return;
        }
    }
}
