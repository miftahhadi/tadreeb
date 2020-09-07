<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
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
            'soal.konten' => 'required',
            'jawaban' => '',
            'benar' => ''
        ];
    }

    public function messages()
    {
        return [
            'soal.konten.required' => 'Konten tidak boleh kosong'
        ];
    }
}
