<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'code', 'date', 'menu_id', 'amount', 'request', 'distribution_id', 'subtotal', 'pay', 'change', 'status'
    ];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    function getTransaction($id = null)
    {
        if (!empty($id)) {
            return $this->db->table('transactions as a')
                ->select('a.*, c.name as menuName, d.name as categoryName, g.name as employeeName')
                ->join('users as b', 'b.id = a.user_id')
                ->join('menus as c', 'c.id = a.menu_id')
                ->join('categories as d', 'd.id = c.category_id')
                ->join('distributions as e', 'e.id = a.distribution_id')
                ->join('users_employees as f', 'f.user_id = a.user_id')
                ->join('employees as g', 'g.id = f.employee_id')
                ->get()->getRowObject();
        }

        return $this->db->table('transactions as a')
            ->select('a.*, c.name as menuName, d.name as categoryName, e.name as distributionName, g.name as employeeName')
            ->join('users as b', 'b.id = a.user_id')
            ->join('menus as c', 'c.id = a.menu_id')
            ->join('categories as d', 'd.id = c.category_id')
            ->join('distributions as e', 'e.id = a.distribution_id')
            ->join('users_employees as f', 'f.user_id = a.user_id')
            ->join('employees as g', 'g.id = f.employee_id')
            ->get()->getResultObject();
    }

    function getTransactionByDate($from, $to)
    {
        return $this->db->table('transactions as a')
            ->select('a.*, c.*, c.name as menuName, d.name as categoryName, e.name as distributionName, g.name as employeeName')
            ->join('users as b', 'b.id = a.user_id')
            ->join('menus as c', 'c.id = a.menu_id')
            ->join('categories as d', 'd.id = c.category_id')
            ->join('distributions as e', 'e.id = a.distribution_id')
            ->join('users_employees as f', 'f.user_id = a.user_id')
            ->join('employees as g', 'g.id = f.employee_id')
            ->where('a.date >=', $from)
            ->where('a.date <=', $to)
            ->get()->getResultObject();
    }
}
