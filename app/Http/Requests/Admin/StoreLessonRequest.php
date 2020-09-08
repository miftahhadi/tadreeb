<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'judul' => 'required',
            'slug' => ['required', 'unique:lessons'],
            'deskripsi' => ''
        ];
    }

    public function messages()
    {
        return [
            'judul.required' => 'Judul tidak boleh kosong',
            'slug.required' => 'Slug URL tidak boleh kosong',
            'slug.unique' => 'Slug ini sudah dipakai, mohon buat slug yang lain'
        ];
    }
}
