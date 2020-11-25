<?php

namespace App\Http\Controllers\Front;

use App\Classroom;
use App\ClassroomExam;
use App\Exam;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Front\ExamHistoryService;

class ExamHistoryController extends Controller
{
    protected $service;

    public function __construct(ExamHistoryService $examHistoryService)
    {   
        $this->service = $examHistoryService;
    }

    public function showHistory(Classroom $classroom, Exam $exam, Request $request)
    {
        $classexam = ClassroomExam::where([
                                            ['classroom_id', $classroom->id],
                                            ['exam_id', $exam->id]
                                        ])
                                    ->first();
        
        return view('front.ujian.riwayat', [
            'title' => 'Riwayat Pengerjaan Ujian',
            'kelas' => $classroom,
            'exam' => $exam
        ]);
    }

    public function showResult()
    {
        
    }
}
