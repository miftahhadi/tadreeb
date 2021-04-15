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
    public function showInfo(Classroom $kelas, Exam $exam)
    {
        $exam->loadCount('questions');

        $examable = $exam->pivot;

        return view('front.ujian.info', [
            'title' => $exam->judul . ' - ' . $kelas->nama,
            'kelas' => $kelas,
            'exam' => $exam,
            'examable' => $examable
        ]);
    }

    public function showExam(Classroom $kelas, Exam $exam)
    {
        if (!$this->service->canDoExam()) {
            return redirect(route('dashboard'));
        }

        return view('front.ujian.kerjakan', [
            'title' => $exam->judul . ' - ' . $kelas->nama,
            'kelas' => $kelas,
            'exam' => $exam,
            'classexamuserId' => $this->service->getClassExamUserId(),
            'service' => $this->service
        ]);
    }

}
