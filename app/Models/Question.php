<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];
    protected $with = ['answers'];
    protected $appends = ['input_type'];

    public function exam()
    {
        return $this->belongsToMany(Exam::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function getInputTypeAttribute()
    {
        return ($this->tipe == 'Jawaban Ganda') ? 'checkbox' : 'radio';
    }


}
