<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use CodeIgniter\Validation\Validation;
use Config\Services;

class Category extends BaseController
{
    private CategoryModel $category;
    protected Validation $validation;

    public function __construct()
    {
        $this->category = new CategoryModel();
        $this->validation = Services::validation();
    }

    public function dataCategory($index = null)
    {
        $category = $this->category->findAll();
        $view = !empty($index) ? 'index' : '';

        return view("category/$view", [
            'title' => 'Kategori',
            'category' => $category
        ]);
    }

    public function index()
    {
        return $this->dataCategory('index');
    }

    public function create()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        return $this->response->setJSON([
            view('category/add', ['title' => 'Tambah Kategori'])
        ]);
    }

    public function save()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $this->validation->setRules(
            ['name' => 'trim|required'],
            ['name' => ['required' => 'Nama kategori harus diisi']]
        );

        $errors = [];
        if ($this->validation->withRequest($this->request)->run() === false) {
            $errors = $this->validation->getErrors();
        } else {
            $this->category->insert([
                'name' => $this->request->getVar('name')
            ]);
        }

        return $this->response->setJSON(
            !empty($errors) ? $errors : [$this->dataCategory()]
        );
    }


    public function edit()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $id = $this->request->getVar('id');

        $category = $this->category->find($id);

        if (empty($category)) return $this->failNotFound('Category not found');

        return $this->response->setJSON([
            view('category/edit', [
                'title' => 'Edit Kategori',
                'category' => $this->category->find($id),
            ])
        ]);
    }

    public function update()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $this->validation->setRules(
            ['name' => 'trim|required'],
            ['name' => ['required' => 'Nama kategori harus diisi']]
        );

        $input = $this->request->getVar();

        $errors = [];
        if ($this->validation->withRequest($this->request)->run() === false) {
            $errors = $this->validation->getErrors();
        } else {
            $category = $this->category->find($input['id']);

            if (empty($category)) return $this->failNotFound('Category not found');

            $this->category->update(['id' => $input['id']], [
                'name' => $input['name']
            ]);
        }

        return $this->response->setJSON(
            !empty($errors) ? $errors : [$this->dataCategory()]
        );
    }

    public function delete()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $id = $this->request->getVar('id');

        $category = $this->category->find($id);

        if (empty($category)) return $this->failNotFound('Category not found');

        $this->category->delete($id);

        return $this->response->setJSON([$this->dataCategory()]);
    }
}