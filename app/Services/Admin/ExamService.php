<?php

namespace App\Services\Admin;

use App\Exam;

class ExamService
{
    public function createExam($data)
    {
        return auth()->user()->exams()->create($data);
    }

    public $questionTypes = [
        [
            'type' => 'Jawaban Ganda',
            'value' => 'multiple'

        ],
        [
            'type' => 'Pilihan Ganda',
            'value' => 'single'
        ],
        [
            'type' => 'Benar-Salah',
            'value' => 'benarsalah'
        ],
        [
            'type' => 'صحيح-خطأ',
            'value' => 'benarsalahArabic'
        ]
    ];

    public $answerIcons = [
        'benar' => '<i class="fas fa-check-circle"></i>',
        'salah' => '<i class="fas fa-times-circle"></i>'
    ];

}