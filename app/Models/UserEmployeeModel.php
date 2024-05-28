<?php

namespace App\Models;

use CodeIgniter\Model;

class UserEmployeeModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'users_employees';
    protected $allowedFields = [
        'user_id', 'employee_id', 'status'
    ];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
