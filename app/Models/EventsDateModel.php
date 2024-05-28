<?php

namespace App\Models;

use CodeIgniter\Model;

class EventsDateModel extends Model
{
    protected $table = 'event_dates';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'start', 'end', 'user_id', 'event_id'
    ];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    function getEventDate($user_id)
    {
        return $this->db
            ->table('event_dates as a')
            ->select('*, a.id as id_date')
            ->where('a.user_id', $user_id)
            ->join('events as b', 'b.id = a.event_id')
            ->get()
            ->getResultObject();
    }
}
