<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
Use App\Models\User;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return auth()->user()->can('edit user');
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'akun.nama' => 'required',
            'akun.email' => ['required', Rule::unique('users', 'email')->ignore($this->user)],
            'akun.username' => ['required', Rule::unique('users', 'username')->ignore($this->user)],
            'role' => '',
            'profil.gender' => '',
            'profil.tanggal_lahir' => '',
            'profil.whatsapp' => '',
            'profil.telegram' => ''
        ];
    }

    public function messages()
    {
        return [
            'akun.nama.required' => 'Nama tidak boleh kosong',
            'akun.email.required' => 'Email tidak boleh kosong',
            'akun.email.unique' => 'Email ini sudah digunakan, mohon gunakan email lain',
            'akun.username.required' => 'Username tidak boleh kosong',
            'akun.username.unique' => 'Usernama ini sudah digunakan, mohon gunakan username lain',
            'akun.password' => 'Password tidak boleh kosong'
        ];
    }
}
