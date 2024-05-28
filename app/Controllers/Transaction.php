<?php

namespace App\Controllers;

use App\Models\ProfileModel;
use App\Models\TransactionDatatable;
use App\Models\TransactionModel;
use Config\Services;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use \PhpOffice\PhpSpreadsheet\IOFactory;

class Transaction extends BaseController
{
    private ProfileModel $profile;
    private TransactionModel $transaction;

    public function __construct()
    {
        $this->transaction = new TransactionModel();
        $this->profile = new ProfileModel();
    }

    public function index()
    {
        $transaction = $this->transaction->getTransaction();

        $data = [
            'title' => 'Transaksi',
            'transaction' => $transaction
        ];

        return view('transaction/index', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $transaction = new TransactionDatatable($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $transaction->get_datatables();
            $data = [];
            $no = $request->getPost('start');
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $btnEdit = "<a href=\"employee/edit/$list->id\" class=\"btn btn-warning btn-sm rounded\"><i class=\"fas fa-edit\"> Edit</i></a>";
                $btnDelete = "<button class=\"btn btn-danger btn-sm rounded\" onClick=\"destroy($list->id)\"><i class=\"fas fa-trash\"> Hapus</i></button>";
                $btnDetail = "<a id='detail' onclick=\"detail($list->id)\"><i class=\"fas fa-info-circle\"></i></a>";

                $row[] = $no;
                $row[] = $list->code;
                $row[] = $list->menuName;
                $row[] = $list->categoryName;
                $row[] = $list->categoryName;
                $row[] = $list->employeeName;
                $row[] = format_day($list->date);
                $row[] = $list->amount;
                $row[] = $list->distributionName;
                $row[] = $btnDetail;
                $row[] = $btnEdit . ' ' . $btnDelete;

                $row[] = '';
                $data[] = $row;
            }

            return $this->response->setJSON([
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $transaction->count_all(),
                'recordsFiltered' => $transaction->count_filtered(),
                'data' => $data,
            ]);
        }
    }

    public function detail()
    {
        if ($this->request->isAjax()) {

            $input = $this->request->getVar();
            $transaksi = $this->transaksi->getDetailsTransaksi($input['no_pesanan'], $input['tanggal_pesanan']);
            $trans = $this->transaksi->getDetailTransaksi($input['no_pesanan'], $input['tanggal_pesanan']);

            $data = [
                'title' => 'Detail Transaction Pesanan',
                'transaction' => $transaksi,
                'trans' => $trans
            ];

            $msg = [
                'data' => view('transaction/detail', $data)
            ];

            return $this->response->setJSON($msg);
        } else {
            return redirect()->back()->with('error', 'Forbidden');
        }
    }
}
