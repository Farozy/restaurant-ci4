<?php


namespace App\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class MenuDatatable extends Model
{
    protected $table = 'menus';
    protected array $column_order = [null, 'a.name', 'category_id', 'stock', null, null, null];
    protected array $column_search = ['a.name', 'category_id', 'stock'];
    protected array $order = ['id' => 'asc'];
    // protected $requests;
    protected $db;
    protected BaseBuilder $dt;
    private RequestInterface $request;

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;

        $this->dt = $this->db->table('menus as a')
            ->select('a.*, b.name AS category_name')
            ->join('categories as b', 'b.id = a.category_id');
    }

    private function _get_datatables_query()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like(
                        $item,
                        $this->request->getPost('search')['value']
                    );
                } else {
                    $this->dt->orLike(
                        $item,
                        $this->request->getPost('search')['value']
                    );
                }
                if (count($this->column_search) - 1 == $i) {
                    $this->dt->groupEnd();
                }
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy(
                $this->column_order[$this->request->getPost('order')['0']['column']],
                $this->request->getPost('order')['0']['dir']
            );
        } elseif (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1) {
            $this->dt->limit(
                $this->request->getPost('length'),
                $this->request->getPost('start')
            );
        }
        $query = $this->dt->get();
        return $query->getResult();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->dt->countAllResults();
    }

    public function count_all()
    {
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }
}
