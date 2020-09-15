<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSidebarSeeder extends Seeder
{

    protected $navs = [
        [
            'judul' => 'Dashboard',
            'route' => 'admin',
            'item' => 'admin',
            'icon' => '<i class="fas fa-laptop"></i>'
        ],

        [
            'judul' => 'Pelajaran',
            'route' => 'pelajaran.index',
            'item' => 'pelajaran',
            'icon' => '<i class="far fa-file-alt"></i>'
        ],

        [
            'judul' => 'Ujian',
            'route' => 'ujian.index',
            'item' => 'ujian',
            'icon' => '<i class="fas fa-pen-alt"></i>'
        ],

        [
            'judul' => 'User',
            'route' => 'user.index',
            'item' => 'user',
            'icon' => '<i class="fas fa-user"></i>'
        ],

        [
            'judul' => 'Pengaturan',
            'route' => 'setting',
            'item' => 'setting',
            'icon' => '<i class="fas fa-cogs"></i>'
        ]
    ];


    public function run()
    {
        DB::table('admin_nav')->insert($this->navs);
    }
}
