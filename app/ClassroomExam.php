<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassroomExam extends Pivot
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'classroomexam_user', 'classroom_exam_id', 'user_id')
                    ->withPivot([
                        'attemp', 
                        'waktu_mulai', 
                        'waktu_selesai'
                    ]);
    }
}
