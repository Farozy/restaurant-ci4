<?php

namespace App\Models;

use CodeIgniter\Model;

class DistributionModel extends Model
{
    protected $table            = 'distributions';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'cost'];

    protected $returnType = 'object';

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
