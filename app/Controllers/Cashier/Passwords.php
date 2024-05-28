<?php

namespace App\Controllers\Cashier;

use App\Controllers\BaseController;
use App\Models\ProfileModel;
use CodeIgniter\Validation\Validation as ValidationAlias;
use Config\Services;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;

class Passwords extends BaseController
{
    private UserModel $user;
    protected ValidationAlias $validation;
    private ProfileModel $profile;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->validation = Services::validation();
        $this->profile = new ProfileModel();
    }

    public function changePassword()
    {
        $user = $this->user->getUser(user()->id);

        $data = [
            'title' => 'Password',
            'id' => user()->id,
            'user' => $user,
            'validation' => $this->validation,
            'name' => $this->profile->where('id', 1)->first(),
            'address' => $this->profile->where('id', 2)->first(),
            'district' => $this->profile->where('id', 3)->first(),
            'regency' => $this->profile->where('id', 4)->first(),
            'phone' => $this->profile->where('id', 5)->first(),
            'logo' => $this->profile->where('id', 6)->first(),
        ];

        return view('cashier/password', $data);
    }

    public function updatePassword()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back();
        }

        $input = $this->request->getVar();

        $user = $this->user->find($input['id']);

        if (!$user) return $this->failNotFound('User not found.');

        $this->validation->setRules(
            [
                'password' => 'trim|required',
                'newPassword' => 'trim|required',
                'confirmPassword' => 'trim|required',
            ],
            [
                'password' => ['required' => 'Field password lama harus diisi'],
                'newPassword' => ['required' => 'Field password baru harus diisi'],
                'confirmPassword' => ['required' => 'Field confirm password harus diisi']
            ]
        );

        $errors = [];
        if ($this->validation->withRequest($this->request)->run() === false) {
            $errors = $this->validation->getErrors();
        } else {
            if (Password::verify($input['password'], $user->password_hash)) {

                $newPassword = Password::hash($input['newPassword']);

                $this->validation->setRules([
                    'newPassword' => [
                        'rules' => 'trim|required|min_length[3]|matches[confirmPassword]',
                        'errors' => [
                            'required' => 'Field password Baru harus diisi',
                            'min_length' => 'Min. 3 karakter untuk password',
                            'matches' => 'Passwords yang dimasukkan tidak cocok'
                        ]
                    ],
                    'confirmPassword' => [
                        'rules' => 'trim|required|matches[newPassword]',
                        'errors' => [
                            'required' => 'Field ulangi password harus diisi',
                            'matches' => 'Passwords yang dimasukkan tidak cocok'
                        ]
                    ],
                ]);

                if ($this->validation->withRequest($this->request)->run() === false) {
                    $errors = $this->validation->getErrors();
                } else {
                    if (Password::verify($input['newPassword'], $user->password_hash)) {
                        $msg = [
                            'title' => 'new password',
                            'newPassword' => 'Passwords baru tidak boleh sama dengan password lama'
                        ];
                    } else {
                        unset($input['confirmPassword']);

                        $this->user->update_user(['id' => $input['id']], ['password_hash' => $newPassword]);

                        $msg = [
                            'icon' => 'success',
                            'text' => 'Passwords berhasil diupdate'
                        ];
                    }
                }
            } else {
                $msg = [
                    'title' => 'password',
                    'password' => 'Passwords Lama Salah'
                ];
            }
        }

        return $this->response->setJSON(!empty($errors) ? $errors : $msg);
    }
}
