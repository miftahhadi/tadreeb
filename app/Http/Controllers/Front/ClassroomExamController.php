<?php

namespace App\Http\Controllers\Front;

use App\Models\Classroom;
use App\Models\Exam;
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
            'kelas' => $classroom,
            'exam' => $exam,
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
            'service' => $this->service
        ]);
    }

}
