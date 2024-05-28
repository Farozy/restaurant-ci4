<?php

namespace App\Validation;

class MenuValidation
{
    public function rules($name = null, $isUpdate = false)
    {
        return [
            'category_id' => 'required',
            'name' => "trim|required|is_unique[menus.name,name,$name]",
            'stock' => 'trim|required|is_natural',
            'cost' => 'trim|required',
            'sell' => 'trim|required',
            'image' => !$isUpdate ? 'uploaded[image]|' : '' . 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]'
        ];
    }

    public array $messages = [
        'category_id' => [
            'required' => 'Field kategori belum dipilih',
        ],
        'name' => [
            'required' => 'Field nama menu belum diisi',
            'is_unique' => 'Nama menu sudah ada, silakan pilih nama lain'
        ],
        'stock' => [
            'required' => 'Field stok belum diisi',
            'is_natural' => 'Inputan harus berupa angka'
        ],
        'cost' => [
            'required' => 'Field harga pokok belum diisi',
        ],
        'sell' => [
            'required' => 'Field harga jual belum diisi',
        ],
        'image' => [
            'uploaded' => "Gambar belum dipilih",
            'max_size' => 'Ukuran gambar terlalu besar',
            'is_image' => 'Yang anda upload bukan gambar',
            'mime_in' => 'Yang anda upload bukan gambar'
        ]
    ];
}
