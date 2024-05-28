<?php

namespace App\Controllers\Cashier;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\ProfileModel;

class Menu extends BaseController
{
    private MenuModel $menu;
    private ProfileModel $profile;

    public function __construct()
    {
        $this->profile = new ProfileModel();
        $this->menu = new MenuModel();
    }

    public function detail()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $id = $this->request->getVar('id');
        $menu = $this->menu->getMenu($id);
        $name = $this->profile->where('id', 1)->first();

        $data = [
            'title' => 'Detail Menu',
            'menu' => $menu,
            'name' => !empty($name) ? $name : 'Restoran',
            'address' => $this->profile->where('id', 2)->first(),
            'district' => $this->profile->where('id', 3)->first(),
            'regency' => $this->profile->where('id', 4)->first(),
            'phone' => $this->profile->where('id', 5)->first(),
            'logo' => $this->profile->where('id', 6)->first(),
        ];

        return $this->response->setJSON([
            view('cashier/detail_menu', $data)
        ]);
    }

    public function searchMenu()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $search = $this->request->getVar('search');
        $countItems = $this->request->getVar('countItems');
        $menu = $this->menu->searchMenu($search);

        $idMenu = [];
        if (!empty($countItems)) {
            foreach ($countItems as $row) {
                $idMenu[] = $row['id_menu'];
            }
        }

        $data = [
            'menu' => $menu,
            'valStok' => $this->request->getVar('valStok'),
            'idMenu' => $idMenu,
            'countItems' => $countItems
        ];

        return $this->response->setJSON([
            'data' => view('cashier/search_menu', $data),
            'menu' => $menu,
        ]);
    }

    public function getMenu()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $id = $this->request->getVar('id');
        $menu = $this->menu->getMenu($id);

        return $this->response->setJSON($menu);
    }
}
