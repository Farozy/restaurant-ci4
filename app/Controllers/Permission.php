<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Validation\PermissionValidation;
use CodeIgniter\Validation\Validation as ValidationAlias;
use Config\Services;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\PermissionModel;

class Permission extends BaseController
{
    private PermissionModel $permission;
    protected ValidationAlias $validation;
    private PermissionValidation $permissionValidation;
    private GroupModel $group;

    public function __construct()
    {
        $this->permission = new PermissionModel();
        $this->group = new GroupModel();
        $this->permissionValidation = new PermissionValidation();
        $this->validation = Services::validation();
    }

    public function dataPermission($index = null)
    {
        $permission = $this->permission->findAll();
        $view = $index !== null ? 'index' : 'data';

        return view("permission/$view", [
            'title' => 'Permission',
            'permission' => $permission
        ]);
    }

    public function index()
    {
        return $this->dataPermission('index');
    }

    public function create()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        return $this->response->setJSON([
            view('permission/add', ['title' => 'Tambah Permission'])
        ]);
    }

    public function save()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $input = $this->request->getVar();

        $errors = [];
        if (!$this->validate($this->permissionValidation->rules, $this->permissionValidation->messages)) {
            $errors = $this->validation->getErrors();
        } else {
            $this->permission->insert([
                'name' => $input['name'],
                'description' => $input['description']
            ]);
        }

        return $this->response->setJSON(
            !empty($errors) ? $errors : [$this->dataPermission()]
        );
    }

    public function edit()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $id = $this->request->getVar('id');

        $permission = $this->permission->find($id);

        if (empty($permission)) return $this->failNotFound('Permission not found');

        return $this->response->setJSON([
            view('permission/edit', [
                'title' => 'Edit Role',
                'permission' => $permission,
            ])
        ]);
    }

    public function update()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $input = $this->request->getVar();

        $errors = [];
        if (!$this->validate($this->permissionValidation->rules, $this->permissionValidation->messages)) {
            $errors = $this->validation->getErrors();
        } else {
            $permission = $this->permission->find($input['id']);

            if (empty($permission)) return $this->failNotFound('Permission not found');

            $this->permission->update(['id' => $input['id']], [
                'name' => $input['name'],
                'description' => $input['description']
            ]);
        }

        return $this->response->setJSON(
            !empty($errors) ? $errors : [$this->dataPermission()]
        );
    }

    public function delete()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $id = $this->request->getVar('id');

        $permission = $this->permission->find($id);

        if (empty($permission)) return $this->failNotFound('Permission not found');

        $this->group->removePermissionFromAllGroups($id);

        $this->permission->delete($id);

        return $this->response->setJSON([$this->dataPermission()]);
    }
}
