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
                            'buka_otomatis', 
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


    public function usersDoneExam($examableId)
    {
        return $this->users()
                        ->whereHas('examable', function (Builder $query) use ($examableId) {
                            $query->where('examable_id', $examableId);
                        })
                        ->get()
                        ->each(function ($user) use ($examableId) {
                            $user->examData = $user->classExamUsers()->where('examable_id', $examableId)->first();
                        });
    }

    public function usersNotDoneExam($examableId)
    {
        return $this->users()
                    ->whereDoesntHave('examable', function (Builder $query) use ($examableId) {
                        $query->where('examable_id', $examableId);
                    })
                    ->get();
    }

}
