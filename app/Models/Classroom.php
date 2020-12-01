<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class)->using(ClassroomExam::class)
                                                ->withPivot([
                                                    'id', 
                                                    'tampil', 
                                                    'buka', 
                                                    'buka_hasil', 
                                                    'tampil_otomatis', 
                                                    'batas_buka', 
                                                    'durasi', 
                                                    'attempt'
                                                ]);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
