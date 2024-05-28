<?php

namespace App\Controllers;

use App\Models\ProfileModel;
use CodeIgniter\Validation\Validation;
use Config\Services;

class Profile extends BaseController
{
    protected ProfileModel $profile;
    protected Validation $validation;

    public function __construct()
    {
        $this->profile = new ProfileModel();
        $this->validation = Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => 'Profil',
            'name' => $this->profile->where('id', 1)->first(),
            'address' => $this->profile->where('id', 2)->first(),
            'district' => $this->profile->where('id', 3)->first(),
            'regency' => $this->profile->where('id', 4)->first(),
            'phone' => $this->profile->where('id', 5)->first(),
            'logo' => $this->profile->where('id', 6)->first(),
        ];

        return view('profile/index', $data);
    }

    public function save()
    {
        $input = $this->request->getVar();
        $file = $this->request->getFile('logo');
        $LogoLama = $this->request->getVar('logoLama');
        $profile = $this->profile->findAll();

        if (count($profile) === 0) {

            if (isset($input['name'])) {
                $this->profile->set('description', $input['name']);
                $this->profile->where('id', 1);
                $this->profile->insert();
            }

            if (isset($input['address'])) {
                $this->profile->set('description', $input['address']);
                $this->profile->where('id', 2);
                $this->profile->insert();
            }

            if (isset($input['district'])) {
                $this->profile->set('description', $input['district']);
                $this->profile->where('id', 3);
                $this->profile->insert();
            }

            if (isset($input['regency'])) {
                $this->profile->set('description', $input['regency']);
                $this->profile->where('id', 4);
                $this->profile->insert();
            }

            if (isset($input['phone'])) {
                $this->profile->set('description', $input['phone']);
                $this->profile->where('id', 5);
                $this->profile->insert();
            }

            if ($file->getError() == 4) {
                $logo = 'logo_restaurant.png';
            } else {
                $logo = $file->getRandomName();
                $file->move('uploads/images/icon', $logo);
            }

            if (isset($logo)) {
                $this->profile->set('description', $logo);
                $this->profile->where('id', 6);
                $this->profile->insert();
            }
        } else {

            if (isset($input['name'])) {
                $this->profile->set('description', $input['name']);
                $this->profile->where('id', 1);
                $this->profile->update();
            }

            if (isset($input['address'])) {
                $this->profile->set('description', $input['address']);
                $this->profile->where('id', 2);
                $this->profile->update();
            }

            if (isset($input['district'])) {
                $this->profile->set('description', $input['district']);
                $this->profile->where('id', 3);
                $this->profile->update();
            }

            if (isset($input['regency'])) {
                $this->profile->set('description', $input['regency']);
                $this->profile->where('id', 4);
                $this->profile->update();
            }

            if (isset($input['phone'])) {
                $this->profile->set('description', $input['phone']);
                $this->profile->where('id', 5);
                $this->profile->update();
            }

            if ($file->getError() == 4) {
                $logo = $LogoLama;
            } else {
                if ($LogoLama != 'logo_restaurant.png') {
                    unlink('uploads/images/icon/' . $LogoLama);
                }
                $new = $file->getRandomName();
                $file->move('uploads/images/icon', $new);
                $logo = $new;
            }

            if (isset($logo)) {
                $this->profile->set('description', $logo);
                $this->profile->where('id', 6);
                $this->profile->update();
            }
        }

        session()->setFlashdata('success', 'Data berhasil disimpan');
        return redirect()->to('profile');
    }

    public function delete()
    {
        $logo = $this->profile->where('id', 6)->first();

        if ($logo['description'] !== 'logo_restaurant.png') {
            unlink('uploads/images/logo' . $logo['description']);
        }

        $this->profile->truncate();

        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to('Profil');
    }
}
