<?php

namespace App\Controllers;

use App\Models\MyMythAuth;
use App\Validation\RoleValidation;
use CodeIgniter\Validation\Validation as ValidationAlias;
use Config\Services;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\PermissionModel;

class Role extends BaseController
{
    private GroupModel $group;
    protected ValidationAlias $validation;
    private RoleValidation $roleValidation;
    private PermissionModel $permission;
    private MyMythAuth $myMythAuth;

    public function __construct()
    {
        $this->group = new GroupModel();
        $this->permission = new PermissionModel();
        $this->validation = Services::validation();
        $this->roleValidation = new RoleValidation();
        $this->myMythAuth = new MyMythAuth();
    }

    public function getRole()
    {
        $group = $this->group->findAll();
        $rolePermission = [];

        foreach ($group as $gr) {
            foreach ($this->group->getPermissionsForGroup($gr->id) as $permiss) {
                $rolePermission[] = [
                    'idRole' => $gr->id,
                    'idPermission' => $permiss['id'],
                    'roleName' => $gr->name,
                    'permissionName' => $permiss['name']
                ];
            }
        }

        return [
            'group' => $group,
            'rolePermission' => $rolePermission
        ];
    }

    public function dataRole($index = null)
    {
        $result = $this->getRole();

        $group = $result['group'];
        $rolePermission = $result['rolePermission'];

        $view = $index !== null ? 'index' : 'data';

        return view("role/$view", [
            'title' => 'Role',
            'group' => $group,
            'rolePemission' => $rolePermission
        ]);
    }

    public function index()
    {
        return $this->dataRole('index');
    }

    public function create()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        return $this->response->setJSON([
            view('role/add', ['title' => 'Tambah Role'])
        ]);
    }

    public function save()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $input = $this->request->getVar();

        $errors = [];
        if (!$this->validate($this->roleValidation->rules, $this->roleValidation->messages)) {
            $errors = $this->validation->getErrors();
        } else {
            $this->group->insert([
                'name' => $input['name'],
                'description' => $input['description']
            ]);
        }

        return $this->response->setJSON(
            !empty($errors) ? $errors : [$this->dataRole()]
        );
    }

    public function edit()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $id = $this->request->getVar('id');

        $role = $this->group->find($id);

        if (empty($role)) return $this->failNotFound('Role not found');

        return $this->response->setJSON([
            view('role/edit', [
                'title' => 'Edit Role',
                'role' => $role,
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
        if (!$this->validate($this->roleValidation->rules, $this->roleValidation->messages)) {
            $errors = $this->validation->getErrors();
        } else {
            $role = $this->group->find($input['id']);

            if (empty($role)) return $this->failNotFound('Role not found');

            $this->group->update(['id' => $input['id']], [
                'name' => $input['name'],
                'description' => $input['description']
            ]);
        }

        return $this->response->setJSON(
            !empty($errors) ? $errors : [$this->dataRole()]
        );
    }

    public function delete()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $id = $this->request->getVar('id');

        $role = $this->group->find($id);

        if (empty($role)) return $this->failNotFound('Role not found');

        $this->myMythAuth->removeGroupFromAllGroups($id);

        $this->group->delete($id);

        return $this->response->setJSON([$this->dataRole()]);
    }

    public function setPermission($id)
    {
        $role = $this->group->find($id);
        $permissions = $this->permission->findAll();
        $groupPermission = $this->group->getPermissionsForGroup($role->id);
        $idGroupPermission = array_column($groupPermission, 'id');
        $nameGroupPermission = array_column($groupPermission, 'name');

        $rolePermission = [];
        foreach ($permissions as $permiss) {
            $position = strpos($permiss->name, '-');
            if ($position !== false) {
                $name = str_replace('-', ' ', substr($permiss->name, $position + 1));
                $rolePermission[ucwords($name)][] = [
                    'id' => $permiss->id,
                    'permissionName' => $permiss->name
                ];
            }
        }

        return view('role/set_permission', [
            'title' => 'Permission Role',
            'sub_title' => 'Tambah Role',
            'role' => $role,
            'rolePermission' => $rolePermission,
            'idGroupPermission' => $idGroupPermission,
            'groupPermission' => $groupPermission
        ]);
    }

    public function savePermission()
    {
        $input = $this->request->getVar();

        $this->myMythAuth->removeGroupFromAllGroups(intval($input['role']));

        if (!empty($input['permissionId'])) {
            foreach ($input['permissionId'] as $permission) {
                $this->group->addPermissionToGroup($permission, $input['role']);
            }
        }


        setFlashdata('update', 'Role permission berhasil');
        return redirect()->to(route_to('indexRole'));
    }
}
