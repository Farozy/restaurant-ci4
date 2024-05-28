<?php

namespace App\Controllers;

use App\Models\EmployeeDatatable;
use App\Models\EmployeeModel;
use App\Validation\EmployeeValidation;
use CodeIgniter\Files\File;
use CodeIgniter\Images\Handlers\BaseHandler;
use CodeIgniter\Validation\Validation;
use Config\Services;

class Employee extends BaseController
{
    protected EmployeeModel $employee;
    private Validation $validation;
    private EmployeeValidation $employeeValidation;
    protected BaseHandler $image;

    public function __construct()
    {
        $this->employee = new EmployeeModel();
        $this->validation = Services::validation();
        $this->employeeValidation = new EmployeeValidation();
        $this->image = Services::image();
    }

    public function index()
    {
        return view('employee/index', ['title' => 'Karyawan']);
    }

    public function listData()
    {
        $request = Services::request();
        $employees = new EmployeeDatatable($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $employees->get_datatables();
            $data = [];
            $no = $request->getPost('start');
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $btnEdit = "<a href=\"employee/edit/$list->id\" class=\"btn btn-warning btn-sm rounded\"><i class=\"fas fa-edit\"> <span class='d-none d-lg-inline-flex'> Edit</span></i></a>";
                $btnDelete = "<button class=\"btn btn-danger btn-sm rounded\" onClick=\"destroy($list->id)\"><i class=\"fas fa-trash\"> <span class='d-none d-lg-inline-flex'> Hapus</span></i></button>";
                $btnActive = "<button class=\"btn btn-sm btn-success rounded btnActive\" onclick=\"toggle($list->id)\" ><i class=\"fas fa-check\"><span class='d-none d-lg-inline-flex'> Aktif</span></i></button><div>";
                $btnNonActive = "<button class=\"btn btn-sm rounded btn-danger btnNonActive\" onclick=\"toggle($list->id)\"><i class=\"fa fa-power-off\"><span class='d-none d-lg-inline-flex'> Nonaktif</span></i></button><div>";
                $btnDetail = "<a id='detail' onclick=\"detail($list->id)\"><i class=\"fas fa-info-circle\"></i></a>";

                $row[] = $no;
                $row[] = $list->name;
                $row[] = $list->gender === 'male' ? 'Laki-laki' : 'Perempuan';
                $row[] = $list->address;
                $row[] = $list->status ? $btnActive : $btnNonActive;
                $row[] = $btnDetail;
                $row[] = $btnEdit . ' ' . $btnDelete;

                $row[] = '';
                $data[] = $row;
            }

            return $this->response->setJSON([
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $employees->count_all(),
                'recordsFiltered' => $employees->count_filtered(),
                'data' => $data,
            ]);
        }
    }

    public function create()
    {
        $data = [
            'title' => 'Karyawan',
            'sub_title' => 'Tambah Karyawan',
            'validation' => $this->validation,
        ];

        return view('employee/add', $data);
    }

    public function save()
    {
        $input = $this->request->getVar();
        $file = $this->request->getFile('image');

        if (!$this->validate($this->employeeValidation->rules(), $this->employeeValidation->messages)) {
            $this->validation->getErrors();
            return redirect()->back()->withInput();
        }

        if ($file->getError() == 4) {
            if ($input['gender'] == 'male') {
                $sourcePath = 'uploads/images/default/employee-male.png';
            } else {
                $sourcePath = 'uploads/images/default/employee-female.png';
            }

            $fileImage = new File($sourcePath);
            $image = $fileImage->getRandomName();

            $this->image
                ->withFile($sourcePath)
                ->resize(500, 500)
                ->save('uploads/images/employee/' . $image);

        } else {
            $newImage = $file->getRandomName();
            $file->move('uploads/images/employee', $newImage);
            $image = $newImage;
        }

        $data = [
            'name' => $input['name'],
            'gender' => $input['gender'],
            'date_of_birth' => format_year($input['date_of_birth']),
            'place_of_birth' => $input['place_of_birth'],
            'image' => $image,
            'phone' => $input['phone'],
            'address' => $input['address'],
            'email' => $input['email']
        ];

        $this->employee->insert($data);

        session()->setFlashdata('save', 'Data karyawan berhasil');
        return redirect()->to('employee');
    }

    public function edit($id)
    {
        $employee = $this->employee->find($id);

        $data = [
            'title' => 'Edit Karyawan',
            'validation' => $this->validation,
            'employee' => $employee
        ];

        return view('employee/edit', $data);
    }

    public function update()
    {
        $input = $this->request->getVar();
        $file = $this->request->getFile('image');
        $employee = $this->employee->find($input['id']);

        if (!$employee) {
            session()->setFlashdata('error', 'Karyawan tidak ditemukan');
            return redirect()->to('employee');
        }

        if (!$this->validate($this->employeeValidation->rules($input['email']), $this->employeeValidation->messages)) {
            $this->validation->getErrors();
            return redirect()->back()->withInput();
        }

        unlink('uploads/images/employee/' . $employee->image);

        if ($file->getError() == 4) {
            if ($input['gender'] == 'male') {
                $sourcePath = 'uploads/images/default/employee-male.png';
            } else {
                $sourcePath = 'uploads/images/default/employee-female.png';
            }

            $fileImage = new File($sourcePath);
            $image = $fileImage->getRandomName();

            $this->image
                ->withFile($sourcePath)
                ->resize(500, 500)
                ->save('uploads/images/employee/' . $image);
        } else {
            $newImage = $file->getRandomName();
            $file->move('uploads/images/employee', $newImage);
            $image = $newImage;
        }

        $data = [
            'name' => $input['name'],
            'gender' => $input['gender'],
            'date_of_birth' => format_year($input['date_of_birth']),
            'place_of_birth' => $input['place_of_birth'],
            'image' => $image,
            'phone' => $input['phone'],
            'address' => $input['address'],
            'email' => $input['email']
        ];

        $this->employee->update(['id' => $input['id']], $data);

        session()->setFlashdata('update', 'Data karyawan berhasil');
        return redirect()->to('employee');
    }

    public function delete()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $id = $this->request->getVar('id');

        $employee = $this->employee->where('id', $id)->first();

        if (!$employee) return $this->response->setJSON(failResponse(404, 'Employee not found'));

        unlink('uploads/images/employee/' . $employee->image);

        $this->employee->delete($id);

        return $this->response->setJSON([
            view('employee/data', ['title' => 'Karyawan'])
        ]);
    }

    public function detail()
    {
        if ($this->request->isAjax()) {
            $id = $this->request->getVar('id');
            $employee = $this->employee->find($id);

            if (!$employee) return $this->response->setJSON(failResponse(404, 'Employee not found'));

            return $this->response->setJSON([
                view('employee/detail', [
                    'title' => 'Detail Karyawan',
                    'employee' => $employee
                ]),
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function toggle()
    {
        if ($this->request->isAjax()) {

            $id = $this->request->getVar('id');
            $status = $this->employee->find($id)->status;
            $toggle = $status ? 0 : 1;

            $this->employee->update(['id' => $id], ['status' => $toggle]);

            return $this->response->setJSON([
                view('employee/data', ['title' => 'Data Employee'])
            ]);
        } else {
            return redirect()->back();
        }
    }
}
