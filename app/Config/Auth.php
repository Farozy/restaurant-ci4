<?php

namespace App\Config;

use CodeIgniter\Config\BaseConfig;

//use Myth\Auth\Config\Auth as MythAuthConfig;

class Auth extends BaseConfig
{
    /**
     * @var array|string[]
     */
    protected array $views;

    public function __construct()
    {
        parent::__construct();

        $this->views = [
            'login' => '\App\Views\auth\login',
//            'register' => 'auth/custom_register',
//            'forgot' => 'auth/custom_forgot',
//            'reset' => 'auth/custom_reset',
//            'emailForgot' => 'auth/emails/custom_forgot',
//            'emailActivation' => 'auth/emails/custom_activation',
        ];
    }
}