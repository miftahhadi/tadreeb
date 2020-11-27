<?php

namespace App\Services\Front;

use App\ClassExamUser;
use App\User;

class ExamHistoryService 
{
    public function showAllUserResult()
    {

    }

    public function getUserId()
    {

    }

    public function getHistory($input = 0, int $classexamid)
    {
        if (auth()->user()->can('show exam result')) {
            $userId = ($input) ?? auth()->user()->id;
        } else {
            $userId = auth()->user()->id;
        }

        return ClassExamUser::where([
                    ['classroom_exam_id', $classexamid],
                    ['user_id', $userId]
                ])
                ->orderBy('attempt', 'desc')
                ->get();
    }

}