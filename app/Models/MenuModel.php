<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'menus';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'category_id', 'stock', 'cost', 'sell', 'discount', 'image'
    ];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    function getMenu($id = null)
    {
        if (!empty($id)) {
            return $this->db->table('menus as a')
                ->select('a.*, b.name AS categoryName')
                ->where('a.id', $id)
                ->join('categories as b', 'b.id = a.category_id')
                ->get()->getRowObject();
        }

        return $this->db->table('menus as a')
            ->select('a.*, b.name as categoryName')
            ->join('categories as b', 'b.id = a.category_id')
            ->get()->getResultObject();
    }

    public function searchMenu($search): array
    {
        return $this->db->table('menus as a')
            ->select('a.*, b.name as categoryName')
            ->like('a.name', $search)
            ->join('categories as b', 'b.id = a.category_id')
            ->get()->getResultObject();
    }
}
