<?php

namespace App\Services\Front;

use App\Models\ClassExamUser;
use App\Models\User;

class ExamResultService 
{
    protected $user; 

    public function showAllUserResult()
    {

    }

    public function getUserName()
    {
        return $this->user->nama;
    }

    public function getUser($input)
    {
        if (auth()->user()->can('show exam result')) {
            $userId = ($input) ?? auth()->user()->id;
        } else {
            $userId = auth()->user()->id;
        }

        $this->user = User::find($userId);

        return $this;
    }

    public function getHistory($user = 0, int $classexamid) // $Input buat apa ya?
    {
        $this->getUser($user);

        return ClassExamUser::where([
                    ['classroom_exam_id', $classexamid],
                    ['user_id', $this->user->id]
                ])
                ->orderBy('attempt', 'asc')
                ->get();
    }

}