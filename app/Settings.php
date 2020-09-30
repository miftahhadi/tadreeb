<?php 

namespace App;

use Spatie\Valuestore\Valuestore;

class Settings extends Valuestore
{
    public static $default = [
        'app_name' => 'Tadreeb App',

        'app_logo' => '/static/logo.svg',

        'admin_nav_menu' => [
            [
                'name' => 'Dashboard',
                'route' => 'admin',
                'icon' => ''
            ],
            [
                'name' => 'Pelajaran',
                'route' => 'pelajaran.index',
                'icon' => ''
            ],
            [
                'name' => 'Ujian',
                'route' => 'ujian.index',
                'icon' => ''
            ],
            [
                'name' => 'User',
                'route' => 'user.index',
                'icon' => ''
            ],
            [
                'name' => 'Pengaturan',
                'route' => 'setting.index',
                'icon' => ''
            ],
        ]
    ];
}