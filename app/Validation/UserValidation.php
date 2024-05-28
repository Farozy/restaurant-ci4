<?php

namespace App\Validation;

class UserValidation
{
    public function rules($email = null, $isUpdate = false)
    {
        if (empty($email)) {
            $rules = [
                'employee_id' => 'required',
                'group_id' => 'required'
            ];
        }

        $imageRules = [];

        if (!$isUpdate) {
            $imageRules[] = 'uploaded[image]';
        }

        $imageRules[] = 'max_size[image,1024]';
        $imageRules[] = 'is_image[image]';
        $imageRules[] = 'mime_in[image,image/jpg,image/jpeg,image/png]';

        $rules['image'] = implode('|', $imageRules);

        return array_filter($rules);
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
