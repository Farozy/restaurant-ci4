<?php

namespace App\Models;

use CodeIgniter\Model;

class MyMythAuth extends Model
{
    public function removeGroupFromAllGroups(int $groupId)
    {
        return $this->db->table('auth_groups_permissions')
            ->where('group_id', $groupId)
            ->delete();
    }

    public function getUser($id = null)
    {
        if (empty($id)) {
            return $this->db->table('users as a')
                ->select('a.*, c.name as roleName, e.name as employeeName')
                // ->where('active', 1)
                ->join('auth_groups_users as b', 'b.user_id = a.id')
                ->join('auth_groups as c', 'c.id = b.group_id')
                ->join('users_employees as d', 'd.user_id = a.id')
                ->join('employees as e', 'e.id = d.employee_id')
                ->get()->getResultArray();
        }

        return $this->db->table('users as a')
            ->select('a.*, a.image as userImage, b.*, d.*, e.name as employeeName')
            ->where('a.id', $id)
            ->join('auth_groups_users as b', 'b.user_id = a.id')
            ->join('auth_groups as c', 'c.id = b.group_id')
            ->join('users_employees as d', 'd.user_id = a.id')
            ->join('employees as e', 'e.id = d.employee_id')
            ->get()->getRowObject();
    }
}
