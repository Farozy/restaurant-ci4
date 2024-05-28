<?php

namespace App\Controllers\Cashier;

use App\Controllers\BaseController;
use App\Models\ProfileModel;

class Table extends BaseController
{
    private ProfileModel $profile;

    public function __construct()
    {
        $this->profile = new ProfileModel();
    }

    public function index()
    {
        $nama = $this->profile->where('id', 1)->first();
//        $transaction = $this->transaction->getMeja();

        $data = [
            'title' => "Meja",
//            'transaction' => $transaction,
            'name' => !empty($nama) ? $nama : 'Restoran',
            'address' => $this->profile->where('id', 2)->first(),
            'district' => $this->profile->where('id', 3)->first(),
            'regency' => $this->profile->where('id', 4)->first(),
            'phone' => $this->profile->where('id', 5)->first(),
            'logo' => $this->profile->where('id', 6)->first(),
        ];

        return view('cashier/table', $data);
    }
}
