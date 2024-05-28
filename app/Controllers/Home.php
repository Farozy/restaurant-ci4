<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return redirect()->back()->with('error', 'Forbidden');
        // $data = ['title' => 'Home'];
        // return view('templates/main', $data);
        // return view('welcome_message');
    }
    public function accessDenied()
    {
        return view('error/access_denided.html');
    }

}
