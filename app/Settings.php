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
                'item' => 'admin',
                'route' => 'admin',
                'icon' => '<i class="fas fa-laptop"></i>'
            ],
            [
                'name' => 'Pelajaran',
                'item' => 'pelajaran',
                'route' => 'pelajaran.index',
                'icon' => '<i class="far fa-file-alt"></i>'
            ],
            [
                'name' => 'Ujian',
                'item' => 'ujian',
                'route' => 'ujian.index',
                'icon' => '<i class="fas fa-pen-alt"></i>'
            ],
            [
                'name' => 'Grup',
                'item' => 'grup',
                'route' => 'grup.index',
                'icon' => '<i class="fas fa-sitemap"></i>'
            ],
            [
                'name' => 'Kelas',
                'item' => 'kelas',
                'route' => 'kelas.index',
                'icon' => '<i class="fas fa-chalkboard-teacher"></i>'
            ],
            [
                'name' => 'User',
                'item' => 'user',
                'route' => 'user.index',
                'icon' => '<i class="fas fa-user"></i>'
            ],
            [
                'name' => 'Pengaturan',
                'item' => 'setting',
                'route' => 'setting',
                'icon' => '<i class="fas fa-cogs"></i>'
            ],
        ]
    ];
}