<?php

namespace App\Services\Admin;

use App\Models\Group;

class GroupService
{
    public function store($data)
    {
        return Group::create([
            'nama' => $data['judul'],
            'deskripsi' => $data['deskripsi']
        ]);
    }
}