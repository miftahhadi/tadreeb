<?php

namespace App\Http\Controllers\Front;

use App\Models\Classroom;
use App\Models\ClassroomExam;
use App\Models\Exam;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Front\ExamHistoryService;
use App\Models\User;

class ExamHistoryController extends Controller
{
    protected $service;

    public function __construct(ExamHistoryService $examHistoryService)
    {   
        $this->service = $examHistoryService;
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

    public function showResult()
    {
        
    }
}
