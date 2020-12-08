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

    public function score()
    {
        $answers = collect(json_decode($this->answers, true));

        $score = $answers->map(function ($answer) {
            return $answer['score'];
        })->all();

        return array_sum($score);
    }
}
