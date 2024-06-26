<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use \Myth\Auth\Filters\LoginFilter;
use \Myth\Auth\Filters\RoleFilter;
use \Myth\Auth\Filters\PermissionFilter;
use \App\Filters\Cors;
use \App\Filters\AuthFilter;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public array $aliases = [
        'csrf' => CSRF::class,
        'toolbar' => DebugToolbar::class,
        'honeypot' => Honeypot::class,
        'invalidchars' => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'login' => LoginFilter::class,
        'role' => RoleFilter::class,
        'permission' => PermissionFilter::class,
        'cors' => Cors::class,
        'auth' => AuthFilter::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public array $globals = [
        'before' => [
            'cors'
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don’t expect could bypass the filter.
     *
     * @var array
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
//    public array $filters = [
//        'login' => ['before' => ['account/*']]
//    ];
    public array $filters = [
        'login' => ['before' => ['account/*']],
        'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],
        'auth' => ['before' => ['account/*', 'dashboard/*']],
    ];
}
