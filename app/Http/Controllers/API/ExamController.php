<?php

namespace App\Http\Controllers\API;

use App\Exam;
use App\Http\Controllers\Controller;
use App\Question;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function getExam(Exam $exam)
    {
        $exam->loadCount('questions');

        $questionIds = $exam->questions()->get()->pluck('id');

        return json_encode(['exam' => $exam, 'questionIds' => $questionIds]);
    }

    public function getQuestion(Question $soal)
    {
        $answers = $soal->answers()->get();

        return json_encode(['soal' => $soal, 'answers' => $answers]);
    }
}
