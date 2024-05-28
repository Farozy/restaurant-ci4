<?php

namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class Auth extends BaseConfig
{
    public $defaultUserGroup;

    public string $landingRoute = '/';

    public array $reservedRoutes = [
        'login'                   => 'login',
        'logout'                  => 'logout',
        'register'                => 'register',
        'activate-account'        => 'activate-account',
        'resend-activate-account' => 'resend-activate-account',
        'forgot'                  => 'forgot',
        'reset-password'          => 'reset-password',
    ];

    public array $authenticationLibs = [
        'local' => 'Myth\Auth\Authentication\LocalAuthenticator',
    ];

    public array $views = [
        'login'           => 'App\Views\auth\login',
//        'register'        => 'Myth\Auth\Views\register',
//        'forgot'          => 'Myth\Auth\Views\forgot',
//        'reset'           => 'Myth\Auth\Views\reset',
//        'emailForgot'     => 'Myth\Auth\Views\emails\forgot',
//        'emailActivation' => 'Myth\Auth\Views\emails\activation',
    ];

    public $viewLayout = 'Myth\Auth\Views\layout';

    public array $validFields = [
        'email',
        'username',
    ];

    public array $personalFields = [];

    public int $maxSimilarity = 50;

    public bool $allowRegistration = false;

    public ?string $requireActivation = 'Myth\Auth\Authentication\Activators\EmailActivator';

    public ?string $activeResetter = 'Myth\Auth\Authentication\Resetters\EmailResetter';

    public bool $allowRemembering = false;

    public $rememberLength = 30 * DAY;

    public bool $silent = false;

    public string $hashAlgorithm = PASSWORD_DEFAULT;

    public int $hashMemoryCost = 2048; // PASSWORD_ARGON2_DEFAULT_MEMORY_COST;

    public int $hashTimeCost = 4; // PASSWORD_ARGON2_DEFAULT_TIME_COST;

    public int $hashThreads = 4; // PASSWORD_ARGON2_DEFAULT_THREADS;

    public int $hashCost = 10;

    public int $minimumPasswordLength = 8;

    public array $passwordValidators = [
        'Myth\Auth\Authentication\Passwords\CompositionValidator',
        'Myth\Auth\Authentication\Passwords\NothingPersonalValidator',
        'Myth\Auth\Authentication\Passwords\DictionaryValidator',
        // 'Myth\Auth\Authentication\Passwords\PwnedValidator',
    ];

    public array $userActivators = [
        'Myth\Auth\Authentication\Activators\EmailActivator' => [
            'fromEmail' => null,
            'fromName'  => null,
        ],
    ];

    public array $userResetters = [
        'Myth\Auth\Authentication\Resetters\EmailResetter' => [
            'fromEmail' => null,
            'fromName'  => null,
        ],
    ];

    public int $resetTime = 3600;
}