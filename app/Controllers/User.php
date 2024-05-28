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
        $employee = $this->employee->find($input['id_employee']);

        if (!$this->validate($this->userValidation->rules(), $this->userValidation->messages)) {
            $this->validation->getErrors();
            return redirect()->back()->withInput();
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

        $this->user->insert($data);

        $id_user = $this->user->selectMax('id')->first()->id;

        $this->userEmployee->save([
            'user_id' => $id_user,
            'employee_id' => $employee->id
        ]);

        $data_group = [
            'group_id' => $input['group_id'],
            'user_id' => $id_user
        ];

        $this->grous->insert($data_group);

        session()->setFlashdata('save', 'Data user berhasil');
        return redirect()->to('user');
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
        $checkGroup = !empty($input['group_id']) ? $input['group_id'] : null;

        if (!$this->validate($this->userValidation->rules($checkGroup, true), $this->userValidation->messages)) {
            $this->validation->getErrors();
            return redirect()->back()->withInput();
        }

        if (!$user) {
            session()->setFlashdata('error', 'Data user berhasil');
            return redirect()->back();
        }

        $this->grous->set('group_id', $input['group_id']);
        $this->grous->where('user_id', $user->id)->update();

        session()->setFlashdata('update', 'Data user berhasil');
        return redirect()->to('user');
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
            'user' => $this->user->get_data_users($id),
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

    public function UbahPassword()
    {
        if ($this->request->isAjax()) {

            $id = $this->request->getVar('id');

            $data = [
                'title' => 'Ubah Passwords',
                'user' => $this->user->find($id),
            ];

            $msg = [
                'data' => view('user / ubah_pass', $data)
            ];

            return $this->response->setJSON($msg);
        } else {
            return redirect()->back();
        }
    }

    public function simpanUbahPassword()
    {
        if ($this->request->isAjax()) {

            $id = $this->request->getVar('id');
            $passwordLama = $this->request->getVar('passwordLama');
            $passwordBaru = $this->request->getVar('passwordBaru');
            $passwordUlang = $this->request->getVar('passwordUlang');

            $user = $this->user->where('id', $id)->first();

            $oldPass = $this->validate([
                'passwordLama' => [
                    'rules' => 'trim | required',
                    'errors' => [
                        'required' => 'Field password lama harus diisi'
                    ]
                ]
            ]);

            if ($oldPass) {
                if (Password::verify($passwordLama, $user->password_hash)) {

                    $password_baru = Password::hash($passwordBaru);

                    $newPass = $this->validate([
                        'passwordBaru' => [
                            'rules' => 'trim | required | min_length[3] | matches[passwordUlang]',
                            'errors' => [
                                'required' => 'Field password Baru harus diisi',
                                'min_length' => 'Min . 3 karakter untuk password',
                                'matches' => 'Passwords yang dimasukkan tidak cocok'
                            ]
                        ],
                        'passwordUlang' => [
                            'rules' => 'trim | required | matches[passwordBaru]',
                            'errors' => [
                                'required' => 'Field ulangi password harus diisi',
                                'matches' => 'Passwords yang dimasukkan tidak cocok'
                            ]
                        ],
                    ]);

                    if ($newPass) {
                        if (Password::verify($passwordBaru, $user->password_hash)) {
                            $msg = [
                                'data' => [
                                    'icon' => 'error',
                                    'text' => 'Passwords baru tidak boleh sama dengan password lama'
                                ]
                            ];
                        } else {
                            unset($passwordUlang);

                            $this->user->update_user(['id' => $id], ['password_hash' => $password_baru]);

                            $msg = [
                                'data' => [
                                    'icon' => 'success',
                                    'text' => 'Passwords berhasil diubah',
                                    'view' => view('user / data', ['title' => 'User'])
                                ]
                            ];
                        }
                    } else {
                        $msg = [
                            'errors' => [
                                'passwordBaru' => $this->validation->getError('passwordBaru'),
                                'passwordUlang' => $this->validation->getError('passwordUlang'),
                            ]
                        ];
                    }
                } else {
                    $msg = [
                        'data' => [
                            'icon' => 'error',
                            'text' => 'Passwords Lama Salah'
                        ]
                    ];
                }
            } else {
                $msg = [
                    'errors' => [
                        'passwordLama' => $this->validation->getError('passwordLama'),
                    ]
                ];
            }

            return $this->response->setJSON($msg);
        } else {
            return redirect()->back();
        }
    }

    public function resetPassword()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back();
        }

        $id = $this->request->getVar('id');
        $user = $this->user->find($id);

        if (!$user) return $this->response->setJSON(failResponse(404, 'User not found'));

        $newPass = Password::hash($user->username);


        $this->user->update_user(['id' => $id], ['password_hash' => $newPass]);

        return $this->response->setJSON([
            view('user/data', ['title' => 'User'])
        ]);
    }

    public function saveGroupUsers()
    {
        if ($this->request->isAjax()) {

            $input = $this->request->getVar();
            $group = $this->group->findAll();

            $groupId = 0;
            foreach ($group as $row) {
                if ($row['name'] == str_replace(' ', '_', $input['label'])) {
                    $groupId = $row['id'];
                }
            }

            $data_group = [
                'group_id' => $groupId,
                'user_id' => $input['id']
            ];

            $this->grous->insert($data_group);

            $grous = $this->grous->findAll();

            $user_id = [];
            foreach ($grous as $row) {
                $user_id[] = $row['user_id'];
            }

            $idUsers = [];
            foreach ($this->user->get()->getResultArray() as $row) {
                if (!in_array($row['id'], $user_id)) {
                    $idUsers[] = $row['id'];
                }
            }

            $data = [
                'title' => 'User',
                'idUsers' => $idUsers,
                'user' => $this->user->get()->getResultArray(),
                'allUsers' => $this->user->data_users()
            ];

            $msg = [
                'data' => view('user / data', $data)
            ];

            return $this->response->setJSON($msg);
        } else {
            return redirect()->back()->with('error', 'Forbidden');
        }
    }
}
