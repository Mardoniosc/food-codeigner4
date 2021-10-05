<?php

namespace Config;

use App\Filters\AdminFilter;
use App\Filters\LoginFilter;
use App\Filters\VisitanteFilter;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'      => CSRF::class,
        'toolbar'   => DebugToolbar::class,
        'honeypot'  => Honeypot::class,
        'login'     => LoginFilter::class, // filtro de login
        'admin'     => AdminFilter::class, // filtro de perfil Administrador
        'visitante' => VisitanteFilter::class, // filtro de visitante
        // 'throttle'  => Throttler::class, // filtro que ajuda a prenivir ataques de força bruta
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            // 'honeypot',
             'csrf',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = [
        // 'post' => ['throttle']
    ];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [
        'login' => [
            'before' => [
                'admin/*', // Todos os controller que estão dentro do namespace 'admin' só serão acessados após o login
            ]
        ],
        'admin' => [
            'before' => [
                'admin/*', // Todos os controller que estão dentro do namespace 'admin' só serão acessados por administradores
            ]
        ],
    ];
}
