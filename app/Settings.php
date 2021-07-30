<?php 

namespace App;

use Spatie\Valuestore\Valuestore;

class Settings extends Valuestore
{
    public static $default = [
        'app_name' => 'Tadreeb App',

        'app_logo' => '/static/logo.svg',

        'admin_side_menu' => [
            [
                'label' => 'Dashboard',
                'item' => 'admin',
                'link' => 'admin.dashboard',
            ],
            [
                'label' => 'Pelajaran',
                'item' => 'pelajaran',
                'link' => 'admin.pelajaran.index',
            ],
            [
                'label' => 'Ujian',
                'item' => 'ujian',
                'link' => 'admin.ujian.index',
            ],
            [
                'label' => 'Bank Soal',
                'item' => 'soal',
                'link' => 'admin.soal.index',
            ],
            [
                'label' => 'Grup & Kelas',
                'item' => 'grup',
                'link' => 'admin.grup.index',
            ],
            [
                'label' => 'User',
                'item' => 'user',
                'link' => 'admin.user.index',
            ],
            [
                'label' => 'Pengaturan',
                'item' => 'setting',
                'link' => 'admin.setting.index'
            ],
        ],

        'timezone' => '+07:00',

        'tzName' => 'WIB'

    ];
}