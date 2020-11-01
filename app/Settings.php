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
                'route' => 'admin.dashboard',
                'icon' => '<i class="fas fa-laptop"></i>'
            ],
            [
                'name' => 'Pelajaran',
                'item' => 'pelajaran',
                'route' => 'admin.pelajaran.index',
                'icon' => '<i class="far fa-file-alt"></i>'
            ],
            [
                'name' => 'Ujian',
                'item' => 'ujian',
                'route' => 'admin.ujian.index',
                'icon' => '<i class="fas fa-pen-alt"></i>'
            ],
            [
                'name' => 'Grup & Kelas',
                'item' => 'grup',
                'route' => 'admin.grup.index',
                'icon' => '<i class="fas fa-sitemap"></i>'
            ],
            [
                'name' => 'User',
                'item' => 'user',
                'route' => 'admin.user.index',
                'icon' => '<i class="fas fa-user"></i>'
            ],
            [
                'name' => 'Pengaturan',
                'item' => 'setting',
                'route' => 'admin.setting.index',
                'icon' => '<i class="fas fa-cogs"></i>'
            ],
        ]
    ];
}