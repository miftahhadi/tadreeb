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
        $this->examResultservice = $examResultService;
    }

    public function showHistory(Classroom $kelas, Exam $exam, Request $request)
    {
        // $classexamId = $classroom->exams()->find($exam->id)->pivot->id;
    
        // $histories = $this->service->getHistory($request->input('user'), $classexamId);
        $user = $this->examResultservice->getUser($request->user);

        $examable = $exam->classrooms()->findOrFail($kelas->id)->pivot;
        $records = $examable->users()->where('users.id', $user->id)
                                    ->get()
                                    ->map(function($user) {
                                        return $user->pivot;
                                    });

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
        /* $classExam = ClassroomExam::where([
            ['classroom_id', $kelas->id],
            ['exam_id', $exam->id]
        ])->first();

        $this->service->setExam($exam);

        if ($request->input('all')) {

            $result = $this->service->getAllResult($classExam);

        } else {

            $userId = ($request->input('user')) ?? auth()->user()->id;

            $attempt = ($request->input('attempt')) ?? null;

            $result = $this->service->getResult($userId, $classExam->id, $attempt);
        } */
        $exam->loadCount('questions');
        $questions = $exam->questions()->orderByPivot('urutan', 'asc')->get();

        $user = $this->examResultservice->getUser($request->user);
        $examable = $exam->classrooms()->findOrFail($kelas->id)->pivot;
        $attempt = $request->attempt ?? $examable->userLastAttempt($user->id);

        $record = $examable->users()->where('users.id', $user->id)
                                    ->get()
                                    ->filter(function ($data) use ($attempt) {
                                        return $data->pivot->attempt == $attempt;
                                    })
                                    ->first()
                                    ->pivot;
        
        $userAnswers = json_decode($record->answers, true);

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
