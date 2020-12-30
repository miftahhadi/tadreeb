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
            'data.nama' => 'required',
            'data.email' => ['required', Rule::unique('users', 'email')->ignore($this->user)],
            'data.username' => ['required', Rule::unique('users', 'username')->ignore($this->user)],
            'role' => '',
            'data.gender' => '',
            'data.tanggal_lahir' => ''
        ];
    }

    public function messages()
    {
        return [
            'data.nama.required' => 'Nama tidak boleh kosong',
            'data.email.required' => 'Email tidak boleh kosong',
            'data.email.unique' => 'Email ini sudah digunakan, mohon gunakan email lain',
            'data.username.required' => 'Username tidak boleh kosong',
            'data.username.unique' => 'Usernama ini sudah digunakan, mohon gunakan username lain',
            'data.password' => 'Password tidak boleh kosong'
        ];
    }
}
