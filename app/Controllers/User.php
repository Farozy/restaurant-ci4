<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\MyMythAuth;
use App\Models\UserDatatable;
use App\Models\UserEmployeeModel;
use App\Validation\UserValidation;
use CodeIgniter\Files\File;
use CodeIgniter\Images\Handlers\BaseHandler;
use CodeIgniter\Validation\Validation;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;
use Config\Services;

class User extends BaseController
{
    protected UserModel $user;
    protected Validation $validation;
    private EmployeeModel $employee;
    private UserValidation $userValidation;
    protected BaseHandler $image;
    private UserEmployeeModel $userEmployee;
    private GroupModel $group;
    private MyMythAuth $myMythAuth;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->group = new GroupModel();
        $this->employee = new EmployeeModel();
        $this->validation = Services::validation();
        $this->userValidation = new UserValidation();
        $this->image = Services::image();
        $this->userEmployee = new UserEmployeeModel();
        $this->myMythAuth = new MyMythAuth();
    }

    public function index()
    {
        return view('user/index', [
            'title' => 'User'
        ]);
    }

    public function listData()
    {
        $request = Services::request();
        $dataUser = new UserDatatable($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $dataUser->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {

                $no++;
                $row = [];

                $btnEdit = "<a href=\"user/edit/$list->id\" class=\"btn btn-warning btn-sm\"><i class=\"fas fa-edit\"> <span class='d-none d-lg-inline-flex'> Edit</span></i></a>";
                $btnHapus = "<button class=\"btn btn-danger btn-sm\" onclick=\"destroy($list->id)\"><i class=\"fas fa-trash\"> <span class='d-none d-lg-inline-flex'> Hapus</span></i> </button>";
                $toggleClass = $list->active ? 'btn-success' : 'btn-danger';
                $btnToggle = "<button class=\"btn btn-sm rounded-circle $toggleClass\" onclick=\"toggle($list->id)\"><i class=\"fa fa-fw fa-power-off\"></i></button>";
                $btnDetail = "<a id='detail' onclick=\"detail($list->id)\"><i class=\"fas fa-info-circle\"></i></a>";

                $row[] = $no;
                $row[] = ucwords(str_replace('_', ' ', $list->username));
                $row[] = ucwords(str_replace('_', ' ', $list->name));
                $row[] = $btnToggle;
                $row[] = $btnDetail;
                $row[] = $btnEdit . " " . $btnHapus;

                $row[] = '';
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $dataUser->count_all(),
                "recordsFiltered" => $dataUser->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function create()
    {
        $data = [
            'title' => 'User',
            'sub_title' => 'Tambah User',
            'group' => $this->group->findAll(),
            'employee' => $this->employee->where('status', 1)->get()->getResultArray(),
            'validation' => $this->validation
        ];

        return view('user/add', $data);
    }

    public function save()
    {
        $input = $this->request->getVar();
        $file = $this->request->getFile('image');
        $employee = $this->employee->find($input['employee_id']);

        if (!$this->validate($this->userValidation->rules(), $this->userValidation->messages)) {
            $this->validation->getErrors();
            return redirect()->back()->withInput();

        }
        if (!$employee) {
            setFlashdata('error', 'Data karyawan tidak ditemukan');
            return redirect()->back();
        }

        if ($file->getError() == 4) {
            if ($employee->gender == 'male') {
                $sourcePath = 'uploads/images/default/employee-male.png';
            } else {
                $sourcePath = 'uploads/images/default/employee-female.png';
            }

            $fileImage = new File($sourcePath);
            $image = $fileImage->getRandomName();

            $this->image
                ->withFile($sourcePath)
                ->resize(500, 500)
                ->save('uploads/images/user/' . $image);
        } else {
            $newImage = $file->getRandomName();
            $file->move('uploads/images/user', $newImage);
            $image = $newImage;
        }

        $data = [
            'email' => $input['email'],
            'username' => $input['username'],
            'image' => $image,
            'password_hash' => Password::hash($input['password']),
            'activate_hash' => bin2hex(random_bytes(16))
        ];

        if ($this->user->insert($data)) {
            $userId = $this->user->insertID();

            $this->userEmployee->save([
                'user_id' => $userId,
                'employee_id' => $employee->id
            ]);

            $this->group->addUserToGroup($userId, $input['group_id']);

            setFlashdata('save', 'Data user berhasil');
            return redirect()->to(route_to('indexUser'));
        } else {
            setFlashdata('error', 'Data user tidak disimpan');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $user = $this->myMythAuth->getUser($id);

        $data = [
            'title' => 'User',
            'sub_title' => 'Edit User',
            'user' => $user,
            'group' => $this->group->findAll(),
            'employee' => $this->employee->where('status', 1)->get()->getResultArray(),
            'validation' => $this->validation
        ];

        return view('user/edit', $data);
    }

    public function update()
    {
        $input = $this->request->getVar();
        $user = $this->user->find($input['id']);

        if (!$this->validate($this->userValidation->rules(true), $this->userValidation->messages)) {
            $this->validation->getErrors();
            return redirect()->back()->withInput();
        }

        if (!$user) {
            setFlashdata('error', 'Data user tidak ditemukan');
            return redirect()->back();
        }

        $this->group->removeUserFromAllGroups(intval($user->id));
        $this->group->addUserToGroup(intval($user->id), $input['group_id']);

        setFlashdata('update', 'Data user berhasil');
        return redirect()->to(route_to('indexUser'));
    }

    public function delete()
    {
        if ($this->request->isAjax()) {

            $id = $this->request->getVar('id');
            $user = $this->user->find($id);

            if (!$user) return $this->response->setJSON(failResponse(404, 'User not found'));

            unlink('uploads/images/user/' . $user->image);

            $this->userEmployee->where('user_id', $user->id)->delete();

            $this->grous->where('user_id', $user->id)->delete();

            $this->user->delete($id);

            return $this->response->setJSON([
                view('user/data', ['title' => 'User']),
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function getEmployee()
    {
        if ($this->request->isAjax()) {

            $id = $this->request->getVar('id');
            $employee = $this->employee->find($id);

            if (!$employee) return $this->response->setJSON(failResponse(404, 'User not found'));

            return $this->response->setJSON($employee);
        } else {
            return redirect()->back()->with('error', 'Forbidden');
        }
    }

    public function detail()
    {
        if (!$this->request->isAjax()) {
            $this->response->setJSON(failResponse(403, 'Forbidden'));
            return redirect()->back();
        }

        $id = $this->request->getVar('id');

        $data = [
            'title' => 'Detail Data User',
            'user' => $this->myMythAuth->getUser($id),
            'group' => $this->group->findAll(),
        ];

        return $this->response->setJSON([
            view('user/detail', $data)
        ]);
    }

    public function toggle()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back();
        }

        $id = $this->request->getVar('id');
        $status = $this->user->find($id)->active;

        $toggle = $status ? 0 : 1;

        $this->user->set('active', $toggle);
        $this->user->where('id', $id)->update();

        return $this->response->setJSON([
            view('user/data', [
                'title' => 'User'
            ])
        ]);
    }

    public function resetPassword()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back();
        }

        $id = $this->request->getVar('id');
        $user = $this->user->find($id);

        if (!$user) return $this->response->setJSON(failResponse(404, 'User not found'));

        $newPassword = Password::hash($user->username);

        $this->user->update(['id' => $id], ['password_hash' => $newPassword]);

        return $this->response->setJSON([
            view('user/data', ['title' => 'User'])
        ]);
    }
}
