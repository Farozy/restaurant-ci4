<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\MenuDatatable;
use App\Models\MenuModel;
use App\Validation\MenuValidation;
use CodeIgniter\Images\Handlers\BaseHandler;
use CodeIgniter\Validation\Validation;
use Config\Services;

class Menu extends BaseController
{
    private MenuModel $menu;
    protected CategoryModel $category;
    protected BaseHandler $image;
    protected Validation $validation;
    private MenuValidation $menuValidation;

    public function __construct()
    {
        $this->menu = new MenuModel();
        $this->category = new CategoryModel();
        $this->validation = Services::validation();
        $this->menuValidation = new MenuValidation();
        $this->image = Services::image();
    }

    public function index()
    {
        return view('menu/index', ['title' => 'Menu']);
    }

    public function listData()
    {
        $request = Services::request();
        $dataModel = new MenuDatatable($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $dataModel->get_datatables();
            $data = [];
            $no = $request->getPost('start');
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $btnEdit = "<a href=\"menu/edit/$list->id\" class=\"btn btn-warning btn-sm rounded\" data-toggle=\"tooltip\" title=\"Edit Data\"><i class=\"fas fa-edit\"> <span class='d-none d-lg-inline-flex'> Edit</span></i></a>";
                $btnHapus = "<button class=\"btn btn-danger btn-sm\" onClick=\"btnDelete($list->id)\"><i class=\"fas fa-trash\"> <span class='d-none d-lg-inline-flex'> Hapus</span></i></button>";
                $btnDetail = "<a id='detail' onclick=\"detail($list->id)\"><i class=\"fas fa-info-circle\"></i></a>";

                $row[] = $no;
                $row[] = $list->name;
                $row[] = $list->category_name;
                $row[] = $list->stock;
                $row[] = rupiah($list->cost);
                $row[] = rupiah($list->sell);
                $row[] = $btnDetail;
                $row[] = $btnEdit . ' ' . $btnHapus;

                $row[] = '';
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $dataModel->count_all(),
                'recordsFiltered' => $dataModel->count_filtered(),
                'data' => $data,
            ];
            echo json_encode($output);
        }
    }

    public function create()
    {
        $data = [
            'title' => 'Menu',
            'sub_title' => 'Tambah Menu',
            'category' => $this->category->findAll(),
            'validation' => $this->validation
        ];

        return view('menu/add', $data);
    }

    public function save()
    {
        $input = $this->request->getVar();
        $file = $this->request->getFile('image');

        if (!$this->validate($this->menuValidation->rules(), $this->menuValidation->messages)) {
            $this->validation->getErrors();
            return redirect()->back()->withInput();
        }

        $image = $file->getRandomName();
        $this->uploadedImage($file, $image);

        $newMenu = [
            'name' => $input['name'],
            'category_id' => $input['category_id'],
            'stock' => $input['stock'],
            'cost' => str_replace('.', '', $input['cost']),
            'sell' => str_replace('.', '', $input['sell']),
            'discount' => $input['discount'],
            'image' => $image,
        ];

        $this->menu->insert($newMenu);

        session()->setFlashdata('save', 'Data menu disimpan');
        return redirect()->to('menu');
    }

    public function edit($id)
    {
        $menu = $this->menu->getMenu($id);
        $category = $this->category->findAll();

        $data = [
            'title' => 'Menu',
            'sub_title' => 'Edit Menu',
            'menu' => $menu,
            'category' => $category,
            'validation' => $this->validation
        ];

        return view('menu/edit', $data);
    }

    public function update()
    {
        $input = $this->request->getVar();
        $oldImage = $input['oldImage'];
        $file = $this->request->getFile('image');

        if (!$this->validate($this->menuValidation->rules($input['name'], true), $this->menuValidation->messages)) {
            $this->validation->getErrors();
            return redirect()->back()->withInput();
        }

        if ($file->getError() == 4) {
            $image = $oldImage;
        } else {
            unlink('uploads/images/menu/' . $oldImage);
            $image = $file->getRandomName();
            $this->uploadedImage($file, $image);
        }

        $newMenu = [
            'name' => $input['name'],
            'category_id' => $input['category_id'],
            'stock' => $input['stock'],
            'cost' => str_replace('.', '', $input['cost']),
            'sell' => str_replace('.', '', $input['sell']),
            'discount' => $input['discount'],
            'image' => $image,
        ];

        $this->menu->update(['id' => $input['id']], $newMenu);

        session()->setFlashdata('update', 'Data menu berhasil');
        return redirect()->to('menu');
    }

    public function delete()
    {
        if ($this->request->isAjax()) {

            $id = $this->request->getVar("id");
            $menu = $this->menu->find($id);

            if (!$menu) return $this->response->setJSON(failResponse(404, 'Menu not found'));

            unlink('uploads/images/menu/' . $menu->image);

            $this->menu->delete($id);

            return $this->response->setJSON([
                view('menu/data', ['title' => 'Menu'])
            ]);
        } else {
            return redirect()->back()->with('error', 'Forbidden');
        }
    }

    public function detail()
    {
        if ($this->request->isAjax()) {
            $id = $this->request->getVar('id');
            $menu = $this->menu->getMenu($id);

            if (!$menu) return $this->response->setJSON(failResponse(404, 'Menu not found'));

            return $this->response->setJSON([
                view('menu/detail', [
                    'title' => 'Detail Menu',
                    'menu' => $menu
                ]),
            ]);
        } else {
            return redirect()->back();
        }
    }

    private function uploadedImage($file, $image)
    {
        $file->move('uploads/images', $image);
        $imagePath = 'uploads/images/' . $image;

        $this->image
            ->withFile('uploads/images/' . $image)
            ->resize(750, 500, false, 'width')
            ->save('uploads/images/menu/' . $image);

        unlink($imagePath);
    }
}
