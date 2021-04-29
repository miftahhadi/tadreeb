<?php

namespace App\Http\Controllers\Front;

use App\Models\Classroom;
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
        $this->examResultservice = $examResultService;
    }

    public function showHistory(Classroom $kelas, Exam $exam, Request $request)
    {
        $user = $this->examResultservice->getUser($request->user);

        $examable = $exam->classrooms()->findOrFail($kelas->id)->pivot;
        $records = $examable->getUserRecords($user->id);

        return view('front.ujian.riwayat', [
            'title' => 'Riwayat - ' . $exam->judul . ' - ' . $kelas->nama,
            'kelas' => $kelas,
            'exam' => $exam,
            'records' => $records,
            'user' => $user
        ]);
    }

    public function showResult(Classroom $kelas, Exam $exam, Request $request)
    {
        $exam->loadCount('questions');
        $questions = $exam->questions()->orderByPivot('urutan', 'asc')->get();

        $user = $this->examResultservice->getUser($request->user);

        if ($request->user && auth()->user()->canAccessUserExam()) {
            $user = User::findOrFail($request->user);
        } else {
            $user = auth()->user();
        }

        $examable = $exam->classrooms()->findOrFail($kelas->id)->pivot;
        $attempt = $request->attempt ?? $examable->userLastAttempt($user->id);

        $record = $examable->getUserRecordByAttempt($user->id, $attempt);
        
        $userAnswers = collect(json_decode($record->answers, true))
                        ->map(function ($answer) {
                            if (is_array($answer['answers'])) {
                                return $answer['answers'];
                            } else {
                                return [$answer['answers']];
                            }
                        });
        
        return view('front.ujian.hasil-detail', [
            'title' => 'Hasil ' . $exam->judul,
            'kelas' => $kelas,
            'exam' => $exam,
            'examable' => $examable,
            'questions' => $questions,
            'user' => $user,
            'record' => $record,
            'userAnswers' => $userAnswers,
        ]);
    }
}
