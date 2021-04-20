<?php

namespace App\Http\Controllers\Front;

use App\Models\Classroom;
use App\Models\Exam;
use App\Http\Controllers\Controller;
use App\Models\Examable;
use App\Services\Front\ClassroomExamService;
use App\Services\Front\RecordExamService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClassroomExamController extends Controller
{
    public function showInfo(Request $request, Classroom $kelas, Exam $exam)
    {
        $exam->loadCount('questions');
        $examable = $exam->pivot;

        $userAllowed = $examable->isUserAllowed(auth()->user());

        return view('front.ujian.info', [
            'title' => $exam->judul . ' - ' . $kelas->nama,
            'kelas' => $kelas,
            'exam' => $exam,
            'examable' => $examable,
            'userAllowed' => $userAllowed
        ]);
    }

    public function showExam(Classroom $kelas, Exam $exam)
    {
        $examable = $kelas->exams()
                            ->where('exams.id', $exam->id)
                            ->first()
                            ->pivot;
        
        $user = auth()->user();

        if (!$examable->isUserAllowed($user)) {
            return redirect(route('dashboard'));
        }

        if ($user->examStatus($examable->id) == 'Sedang mengerjakan') {
            $examableUser = $examable->getUserLastRecord($user->id);
        } else {
            $examableUser = (new RecordExamService($examable))->makeUserData();
        }

        $examExpires = $examable->isTimed() 
                            ? $examableUser->waktu_mulai->addMinutes($examable->durasi)->valueOf()
                            : 0;

        $questions['data'] = $exam->questions;
        $question['ids'] = $exam->questions->pluck('id');

        dd($questions);

        return view('front.ujian.kerjakan', [
            'title' => $exam->judul . ' - ' . $kelas->nama,
            'kelas' => $kelas,
            'exam' => $exam,
            'examable' => $examable,
            'examableUser' => $examableUser,
            'examExpires' => $examExpires,
            'questions' => $questions
        ]);
    }

}
