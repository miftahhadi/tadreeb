<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded = [];

    public function questions()
    {
        return $this->belongsTo(Question::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('soal_id', 'classroom_exam_id', 'attempt');
    }

    public function userAnswerCorrect(array $userAnswers)
    {
        return $this->benar && in_array($this->id, $userAnswers);
    }

}
