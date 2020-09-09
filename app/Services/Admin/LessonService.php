<?php

namespace App\Services\Admin;

use App\Lesson;

class LessonService
{
    public function createLesson($data)
    {
        return auth()->user()->lessons()->create($data);
    }

    public function destroy(Lesson $pelajaran)
    {
        // Hapus section dan isinya

        // Hapus pelajaran
        return $pelajaran->delete();
    }
}