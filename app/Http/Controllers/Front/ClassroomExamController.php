<?php

namespace App\Http\Controllers\Front;

use App\Classroom;
use App\Exam;
use App\Http\Controllers\Controller;
use App\Services\Front\ClassroomExamService;
use Illuminate\Http\Request;

class ClassroomExamController extends Controller
{
    protected $service;

    public function __construct(ClassroomExamService $classroomExamService)
    {
        $this->service = $classroomExamService;
    }

    public function showInfo(Classroom $classroom,Exam $exam)
    {
        $exam->loadCount('questions');

        return view('front.ujian.info', [
            'title' => $exam->judul . ' - ' . $classroom->nama,
            'kelas' => $classroom,
            'exam' => $exam
        ]);
    }

    public function showExam(Classroom $classroom, Exam $exam)
    {
        return view('front.ujian.kerjakan', [
            'title' => $exam->judul . ' - ' . $classroom->nama,
            'kelas' => $classroom,
            'exam' => $exam
        ]);
    }
}
