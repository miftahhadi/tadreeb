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

    public function printWaktuMulai()
    {
        return $this->waktu_mulai
                        ->tz(settings('timezone'))
                        ->locale('id')
                        ->isoFormat('D MMM Y, HH:mm') 

                . ' ' . settings('tzName');
    }

    public function printWaktuSelesai()
    {
        if (is_null($this->waktu_selesai)) {
            return '';
        } else {
            return $this->waktu_selesai
                        ->tz(settings('timezone'))
                        ->locale('id')
                        ->isoFormat('D MMM Y, HH:mm') 

                . ' ' . settings('tzName');
        }

    }

    public function getAnswersArrays()
    {
        $answers = collect(json_decode($this->answers, true));

        return $answers->map(function ($answer) {
            return is_array($answer['answers']) ? $answer['answers'] : [$answer['answers']];
        })->toArray();
    }
}
