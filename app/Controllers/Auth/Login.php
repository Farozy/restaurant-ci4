<?php

namespace App\Controllers\Auth;

use Myth\Auth\Controllers\AuthController as MythAuthController;

class Login extends MythAuthController
{
    protected $auth;
    protected $config;

    public function __construct()
    {
        parent::__construct();

        helper('auth');
        $this->config = config('App\Config\Auth');
        $this->auth = service('authentication');
    }

    public function index()
    {
        if ($this->auth->check()) {
            $redirectURL = session('redirect_url') ?? site_url('/');
            unset($_SESSION['redirect_url']);

            return redirect()->to($redirectURL);
        }

        // Set a return URL if none is specified
        $_SESSION['redirect_url'] = session('redirect_url') ?? previous_url() ?? site_url('/');

        return $this->_render($this->config->views['login'], ['config' => $this->config]);
    }

    public function attemptLogin()
    {
        $rules = [
            'login' => 'required',
            'password' => 'required',
        ];

        if ($this->config->validFields === ['email']) {
            $rules['login'] .= '|valid_email';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        $remember = (bool)$this->request->getPost('remember');

        $type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (!$this->auth->attempt([$type => $login, 'password' => $password], $remember)) {
            $msgError = strip_tags($this->auth->error());
            $firstPeriodPos = strpos($msgError, '.');
            $shortMessage = substr($msgError, 0, $firstPeriodPos + 1);

            return redirect()->back()->withInput()->with('error',  $shortMessage ?? lang('Auth.badAttempt'));
        }

        if ($this->auth->user()->force_pass_reset === true) {
            return redirect()->to(route_to('reset-password') . '?token=' . $this->auth->user()->reset_hash)->withCookies();
        }

        if (!$this->auth->user()->active) {
            return redirect()->back()->withInput()->with('error', "Akun tidak aktif atau belum aktif");
        }

        if (in_groups('admin')) {
            $redirectURL = route_to('indexAdmin');
        } elseif (in_groups('cashier')) {
            $redirectURL = route_to('indexCashier');
        } else {
            $redirectURL = route_to('indexCustomer');
        }
        unset($_SESSION['redirect_url']);

        return redirect()->to($redirectURL)->withCookies()->with('message', lang('Auth.loginSuccess'));
    }

    public function logout()
    {
        if ($this->auth->check()) {
            $this->auth->logout();
        }

        return redirect()->to(route_to('formLogin'));
    }

}
