<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    public function exam()
    {
        return $this->belongsToMany(Exam::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function inputType()
    {
        if ($this->tipe == 'Jawaban Ganda') {
            return 'checkbox';
        } else {
            return 'radio';
        }
    }

}