<?php

namespace App\Validation;

class UserValidation
{
    public function rules($isUpdate = false)
    {
        $rules = ['group_id' => 'required'];

        if (!$isUpdate) {
            $rules['employee_id'] = 'required';
            $rules['image'] = ['max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]'];
        }

        return $rules;
    }

    public array $messages = [
        'employee_id' => [
            'required' => 'Field karyawan belum dipilih'
        ],
        'group_id' => [
            'required' => 'Field role belum dipilih'
        ],
        'image' => [
            'uploaded' => 'Foto belum dipilih',
            'max_size' => 'Ukuran photos terlalu besar',
            'is_image' => 'Yang anda upload bukan photos',
            'mime_in' => 'Yang anda upload bukan photos'
        ]
    ];
}
