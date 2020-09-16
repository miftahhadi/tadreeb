<?php

namespace App\Services\Admin;

use App\User;
use Illuminate\Support\Facades\Hash;

class UserService 
{
    public function store($request)
    {

        $dataUser = [
            'nama' => $request['user']['nama'],
            'email' => $request['user']['email'],
            'username' => $request['user']['username'],
            'password' => Hash::make($request['user']['password']),
            'gender' => $request['user']['gender'],
            'tanggal_lahir' => $request['user']['tanggal_lahir']
        ];

        $user = User::create($dataUser);

        // assing roles
        $user->assignRole($request['role']);

        return;
    }
}