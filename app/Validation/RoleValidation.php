<?php

namespace App\Validation;

class RoleValidation
{
    public array $rules = [
        'name' => 'trim|required',
        'description' => 'trim|required'
    ];

    public array $messages = [
        'name' => ['required' => 'Nama role harus diisi'],
        'description' => ['required' => 'keterangan role harus diisi']
    ];
}
