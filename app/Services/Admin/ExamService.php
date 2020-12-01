<?php

namespace App\Services\Admin;

use App\Models\Exam;

class ExamService
{

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

    public function createExam($data)
    {
        return auth()->user()->exams()->create($data);
    }

    public function update($data, Exam $exam)
    {
        $exam->judul = $data['judul'];
        $exam->slug = $data['slug'];
        $exam->deskripsi = $data['deskripsi'];

        return $exam->save();
    }

    public function detachQuestions(Exam $exam)
    {
        return $exam->questions()->detach();
    }

    public function delete(Exam $exam)
    {
        $this->detachQuestions($exam);
        
        return $exam->delete();
    }

}