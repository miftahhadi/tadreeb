<?php

namespace App\Services\Front;

use App\Models\User;

class ExamResultService 
{
    public $user;
    public $exam;
    public $template;
    public $classExamUser;

    public function getUser($userId = null)
    {
        if ($userId && auth()->user()->canAccessUserExam()) {
            $user = User::findOrFail($userId);
        } else {
            $user = auth()->user();
        }

        return $user;
    }
    

}