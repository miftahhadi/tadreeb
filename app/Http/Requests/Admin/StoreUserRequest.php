<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('edit user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user.nama' => 'required',
            'user.email' => ['required', 'unique:users,email'],
            'user.username' => ['required', 'unique:users,username'],
            'user.password' => 'required',
            'role' => '',
            'user.gender' => '',
            'user.tanggal_lahir' => ''
        ];
    }

    public function messages()
    {
        return [
            'user.nama.required' => 'Nama tidak boleh kosong',
            'user.email.required' => 'Email tidak boleh kosong',
            'user.email.unique' => 'Email ini sudah digunakan, mohon gunakan email lain',
            'user.username.required' => 'Username tidak boleh kosong',
            'user.username.unique' => 'Usernama ini sudah digunakan, mohon gunakan username lain',
            'user.password' => 'Password tidak boleh kosong'
        ];
    }
}
