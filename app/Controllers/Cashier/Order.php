<?php

namespace App\Controllers\Cashier;

use App\Controllers\BaseController;
use App\Models\DistributionModel;
use App\Models\MenuModel;
use App\Models\ProfileModel;
use App\Models\TransactionModel;
use Myth\Auth\Models\UserModel;

class Order extends BaseController
{
    private ProfileModel $profile;
    private MenuModel $menu;
    private TransactionModel $transaction;
    private UserModel $user;
    private DistributionModel $distribution;

    public function __construct()
    {
        $this->profile = new ProfileModel();
        $this->menu = new MenuModel();
        $this->user = new UserModel();
        $this->transaction = new TransactionModel();
        $this->distribution = new DistributionModel();
    }

    public function checkOrder()
    {
        $input = $this->request->getVar();
        $menu = $this->menu->getMenu();
        $name = $this->profile->where('id', 1)->first();
        $user = $this->user->getUser(user()->id);
        $distribution = $this->distribution->findAll();

        $lastCode = $this->transaction->selectMax('code')->get()->getRowArray();
        $kode = implode($lastCode);
        $kode_tambah = substr($kode, -6, 6);
        $kode_tambah++;
        $number = str_pad($kode_tambah, 6, '0', STR_PAD_LEFT);

        $data = [
            'title' => 'Cek Pesanan',
            'user' => $user,
            'menu' => $menu,
            'distribution' => $distribution,
            'code' => 'CSTR' . $number,
            'menuId' => $input['menu_id'],
            'amount' => $input['amount'],
            'request' => $input['request'],
            'date' => date('d') . ' - ' . month(date('m')) . ' - ' . date('Y'),
            'name' => !empty($name) ? $name : 'Restoran',
            'address' => $this->profile->where('id', 2)->first(),
            'district' => $this->profile->where('id', 3)->first(),
            'regency' => $this->profile->where('id', 4)->first(),
            'phone' => $this->profile->where('id', 5)->first(),
            'logo' => $this->profile->where('id', 6)->first(),
        ];

        return view('cashier/check_order', $data);
    }

    public function saveOrder()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $input = $this->request->getVar();
        $menu = count($input['menuId']);
        $distribution = $this->distribution->find($input['distribution_id']);

        for ($i = 0; $i < $menu; $i++) {
            $data = [
                'user_id' => user()->id,
                'code' => $input['code'],
                'date' => date('Y-m-d'),
                'menu_id' => $input['menuId'][$i],
                'amount' => $input['amount'][$i],
                'request' => $input['request'][$i],
                'distribution_id' => $input['distribution_id'],
                'subtotal' => str_replace('.', '', $input['subtotal']) + $distribution->cost,
                'pay' => str_replace('.', '', $input['pay']),
                'change' => str_replace('.', '', $input['change']),
            ];

//            $this->transaction->insert($data);
        }

        return $this->response->setJSON([]);
    }

    public function getDistribution()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $id = $this->request->getVar('id');

        $distribution = $this->distribution->find($id);

        return $this->response->setJSON($distribution);
    }
}
