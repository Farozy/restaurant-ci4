<?php

namespace App\Models;

use CodeIgniter\Model;

class EventsModel extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'color', 'background', 'user_id'
    ];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    function getEvents($user_id)
    {
        return $this->db
            ->table('events as a')
            ->select('*')
            ->where('a.user_id', $user_id)
            // ->join('events_date as b', 'b.events_id = a.id_events')
            ->groupBy('a.id')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();
    }
}
