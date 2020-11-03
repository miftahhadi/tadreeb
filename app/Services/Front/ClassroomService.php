<?php

namespace App\Services\Front;

class ClassroomService
{
    public $nav = [
        [
            'judul' => 'Beranda',
            'route' => 'kelas.home'
        ],

        [
            'judul' => 'Pelajaran',
            'route' => 'kelas.lessons'
        ],

        [
            'judul' => 'Tugas dan Ujian',
            'route' => 'kelas.works'
        ],

        [
            'judul' => 'Anggota',
            'route' => 'kelas.people'
        ],

    ];
}