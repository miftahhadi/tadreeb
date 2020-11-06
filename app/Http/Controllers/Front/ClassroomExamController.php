<?php

namespace App\Http\Controllers\Front;

use App\Classroom;
use App\ClassroomExam;
use App\Exam;
use App\Http\Controllers\Controller;
use App\Services\Front\ClassroomExamService;
use Carbon\Carbon;
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
        $classexam = ClassroomExam::where([
                                            ['classroom_id', $classroom->id],
                                            ['exam_id', $exam->id]
                                        ])
                                        ->first();


        // $this->service->inExam();
        
        return view('front.ujian.kerjakan', [
            'title' => $exam->judul . ' - ' . $classroom->nama,
            'kelas' => $classroom,
            'exam' => $exam
        ]);
    }
}
