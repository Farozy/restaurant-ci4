<?php

namespace App\Controllers\Cashier;

use App\Controllers\BaseController;
use App\Models\EmployeeModel;
use App\Models\ProfileModel;
use CodeIgniter\Validation\Validation as ValidationAlias;
use Config\Services;
use Myth\Auth\Models\UserModel;

class Profile extends BaseController
{
    private EmployeeModel $employee;
    protected ValidationAlias $validation;
    protected UserModel $user;
    protected ProfileModel $profile;

    public function __construct()
    {
        $this->profile = new ProfileModel();
        $this->user = new UserModel();
        $this->employee = new EmployeeModel();
        $this->validation = Services::validation();
    }

    public function index()
    {
        $user = $this->user->getUser(user()->id);
        $employee = $this->employee->find($user->employee_id);

        $data = [
            'title' => 'Profile',
            'id' => user()->id,
            'user' => $user,
            'validation' => $this->validation,
            'employee' => $employee,
            'name' => $this->profile->where('id', 1)->first(),
            'address' => $this->profile->where('id', 2)->first(),
            'district' => $this->profile->where('id', 3)->first(),
            'regency' => $this->profile->where('id', 4)->first(),
            'phone' => $this->profile->where('id', 5)->first(),
            'logo' => $this->profile->where('id', 6)->first(),
        ];

        return view('cashier/profile', $data);
    }

    public function update()
    {
        $input = $this->request->getVar();
        $file = $this->request->getFile('image');
        $oldImage = $input['oldImage'];

        if ($file->getError() == 4) {
            $image = $oldImage;
        } else {
            unlink('uploads/images/user/' . $oldImage);
            $newImage = $file->getRandomName();
            $file->move('uploads/images/user', $newImage);
            $image = $newImage;
        }

        $data = [
            'username' => $input['username'],
            'image' => $image,
        ];

        $this->user->update_user(['id' => $input['id']], $data);

        session()->setFlashdata('success', 'Data user berhasil diupdate');
        return redirect()->back();
    }
}
