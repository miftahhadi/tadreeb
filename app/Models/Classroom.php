<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        return $this->morphToMany(Exam::class, 'examable')
                        ->using(Examable::class)
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

    public function classroomExam()
    {
        return $this->hasOne(ClassroomExam::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    public function usersDoneExam($classExamId)
    {
        return $this->users()
                        ->whereHas('classroomExams', function (Builder $query) use ($classExamId) {
                            $query->where('classroom_exam_id', $classExamId);
                        })
                        ->get()
                        ->each(function ($user) use ($classExamId) {
                            $user->examData = $user->classExamUsers()->where('classroom_exam_id', $classExamId)->first();
                        });
    }

    public function usersNotDoneExam($classExamId)
    {
        return $this->users()
                    ->whereDoesntHave('classroomExams', function (Builder $query) use ($classExamId) {
                        $query->where('classroom_exam_id', $classExamId);
                    })
                    ->get();
    }

}
