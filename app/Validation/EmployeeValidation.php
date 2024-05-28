<?php

namespace App\Validation;

class EmployeeValidation
{
    public function rules($email = null)
    {
        return [
            'name' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'place_of_birth' => 'required',
            'image' => 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
            'phone' => 'required|is_natural',
            'email' => "required|valid_email|is_unique[employees.email,email,$email]",
            'address' => 'required'
        ];
    }

    public array $messages = [
        'name' => [
            'required' => 'Field nama employee belum diisi',
        ],
        'gender' => [
            'required' => 'Field jenis kelamin belum dipilih',
        ],
        'date_of_birth' => [
            'required' => 'Field tanggal lahir belum diisi',
        ],
        'place_of_birth' => [
            'required' => 'Field tempat lahir belum diisi',
        ],
        'image' => [
            'max_size' => 'Ukuran photos terlalu besar',
            'is_image' => 'Yang anda upload bukan photos',
            'mime_in' => 'Yang anda upload bukan photos',
        ],
        'phone' => [
            'required' => 'Field no telepon belum diisi',
            'is_natural' => 'Field input harus berupa angka'
        ],
        'email' => [
            'required' => 'Field email belum diisi',
            'valid_email' => 'Email tidak valid',
            'is_unique' => 'Email sudah terdaftar'
        ],
        'address' => [
            'required' => 'Field alamat belum diisi',
        ],
    ];
}
