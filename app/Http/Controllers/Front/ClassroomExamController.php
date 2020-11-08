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

    public function showInfo(Classroom $classroom, Exam $exam)
    {
        $exam->loadCount('questions');

        $this->service->info($exam, $classroom);

        return view('front.ujian.info', [
            'title' => $exam->judul . ' - ' . $classroom->nama,
            'service' => $this->service
        ]);
    }

    public function showExam(Classroom $classroom, Exam $exam)
    {

        $this->service->info($exam, $classroom);

        if (!$this->service->canDoExam()) {
            return redirect(route('dashboard'));
        }
        
        return view('front.ujian.kerjakan', [
            'title' => $exam->judul . ' - ' . $classroom->nama,
            'kelas' => $classroom,
            'exam' => $exam,
            'classexamuserId' => $this->service->getClassExamUserId(),
        ]);
    }
}
