<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('home/index', ['title' => 'Home']);
    }
    public function accessDenied()
    {
        return view('error/access_denided.html');
    }

}
