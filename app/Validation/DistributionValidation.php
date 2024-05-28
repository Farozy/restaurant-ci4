<?php

namespace App\Validation;

class DistributionValidation
{
    public array $rules = [
        'name' => 'trim|required',
        'cost' => 'trim|required'
    ];

    public array $messages = [
        'name' => ['required' => 'Nama distribusi harus diisi'],
        'cost' => ['required' => 'Harga distribusi harus diisi']
    ];
}
