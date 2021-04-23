<?php

namespace App\Services\Front;

use App\Models\ClassExamUser;
use App\Models\ClassroomExam;
use App\Models\Exam;
use App\Models\User;

class ExamResultService 
{
    public $user;
    public $exam;
    public $template;
    public $classExamUser;

    public function setExam(Exam $exam)
    {
        $this->exam = $exam;

        $this->exam->load('questions.answers');

        return $this;
    }

    public function showAllUserResult()
    {

    }

    public function getUserName()
    {
        return $this->user->nama;
    }

    public function getUser($userId = null)
    {
        if ($userId && auth()->user()->canAccessUserExam()) {
            $user = User::findOrFail($userId);
        } else {
            $user = auth()->user();
        }

        return $user;
    }

    // public function getHistory($user = 0, int $classexamid)
    // {
    //     $this->getUser($user);

    //     return ClassExamUser::where([
    //                 ['classroom_exam_id', $classexamid],
    //                 ['user_id', $this->user->id]
    //             ])
    //             ->orderBy('attempt', 'desc')
    //             ->get();
    // }

    public function getAllResult(ClassroomExam $classExam)
    {

    }

    public function getResult(int $userId, int $classExamId, $attempt = null)
    {
        $this->getUser($userId);
        $this->template = 'front.ujian.hasil-detail';

        $this->setClassExamUser($userId, $classExamId, $attempt);

        return $this->classExamUser;
    }
    
    public function userAnswers()
    {
        return $this->classExamUser->getAnswersArrays();
    }

    public function setClassExamUser(int $userId, int $classExamId, $attempt = null)
    {
        if (is_null($attempt)) {
            $classExamUser = ClassExamUser::where([
                ['classroom_exam_id', $classExamId],
                ['user_id', $userId]
            ])->orderBy('attempt', 'desc')
                ->first();
        } else {
            $classExamUser = ClassExamUser::where([
                ['classroom_exam_id', $classExamId],
                ['user_id', $userId],
                ['attempt', $attempt]
            ])->first();
        }

        $this->classExamUser = $classExamUser;

        return $this;
    }

}