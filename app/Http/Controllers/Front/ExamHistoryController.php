<?php

namespace App\Http\Controllers\Front;

use App\Classroom;
use App\ClassroomExam;
use App\Exam;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Front\ExamHistoryService;
use App\User;

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
dd($histories);        
        return view('front.ujian.riwayat', [
            'title' => 'Riwayat - ' . $exam->judul . ' - ' . $classroom->nama,
            'kelas' => $classroom,
            'exam' => $exam,
            'histories' => $histories
        ]);
    }

    public function showResult()
    {
        
    }
}
