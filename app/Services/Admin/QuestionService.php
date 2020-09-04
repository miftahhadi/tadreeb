<?php

namespace App\Services\Admin;

class QuestionService
{
    public function createQuestionForm($request)
    {
        $choices = $request['choices'] ?? 0;
        
        if ($request['type'] == 'benarsalah' || $request['type'] == 'benarsalahArabic') {
            $choices = 2;
        }

        $value = [];

        if ($request['type'] == 'benarsalah') {
            $value = [
                'benar' => 'Benar', 
                'salah' => 'Salah'
            ];
        }

        if ($request['type'] == 'benarsalahArabic') {
            $value = [
                'benar' => 'صحيح',
                'salah' => 'خطأ'
            ];
        }

        $option = '';
        
        if ($request['type'] == 'multiple') {
            $option = 'checkbox';
        } else {
            $option = 'radio';
        }

        return [
            'choices' => $choices,
            'value' => $value,
            'option' => $option
        ];
    }
}