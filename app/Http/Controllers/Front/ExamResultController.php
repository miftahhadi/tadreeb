<?php

namespace App\Http\Controllers\Front;

use App\Models\Classroom;
use App\Models\ClassroomExam;
use App\Models\Exam;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Front\ExamResultService;
use App\Models\User;

class ExamResultController extends Controller
{
    protected $service;

    public function __construct(ExamResultService $examResultService)
    {   
        $this->service = $examResultService;
    }

    public function showHistory(Classroom $classroom, Exam $exam, Request $request)
    {
        $classexamId = $classroom->exams()->find($exam->id)->pivot->id;
    
        $histories = $this->service->getHistory($request->input('user'), $classexamId);

        return view('front.ujian.riwayat', [
            'title' => 'Riwayat - ' . $exam->judul . ' - ' . $classroom->nama,
            'kelas' => $classroom,
            'exam' => $exam,
            'histories' => $histories,
            'nama' => $this->service->getUserName()
        ]);
    }

    public function showResult(Classroom $classroom, Exam $exam, Request $request)
    {
        $classExam = ClassroomExam::where([
            ['classroom_id', $classroom->id],
            ['exam_id', $exam->id]
        ])->first();

        $this->service->setExam($exam);

        if ($request->input('all')) {

            $result = $this->service->getAllResult($classExam);

        } else {

            $userId = ($request->input('user')) ?? auth()->user()->id;

            $attempt = ($request->input('attempt')) ?? null;

            $result = $this->service->getResult($userId, $classExam->id, $attempt);
        }

        return view($this->service->template, [
            'title' => 'Hasil ' . $exam->judul,
            'kelas' => $classroom,
            'exam' => $exam,
            'service' => $this->service,
            'userAnswers' => $this->service->userAnswers(),
            'bukaKunci' => $classExam->buka_hasil
        ]);
    }
}
