<?php

namespace App\Services\Admin;

use App\Lesson;

class LessonService
{
    public function createLesson($data)
    {
        return auth()->user()->lessons()->create($data);
    }
}