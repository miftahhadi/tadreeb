<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ExamableUser extends Pivot
{
    use HasFactory;

    public function examable()
    {
        return $this->belongsTo(Examable::class);
    }

    public function assignScore($userAnswers)
    {
        $scores = 0;

        if (is_array($userAnswers)) {
            foreach ($userAnswers as $id) {
                $scores += (Answer::find($id))->nilai;
            }            
        } else {
            $scores += (Answer::find($userAnswers))->nilai;
        }

        $this->save();

        return $scores;
    }
}
