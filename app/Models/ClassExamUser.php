<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassExamUser extends Pivot
{
    protected $table = 'classroomexam_user';
    public $incrementing = true;

    protected $dates = [
        'waktu_mulai',
        'waktu_selesai',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
