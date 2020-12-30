<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'email', 'username', 'password', 'gender', 'tanggal_lahir'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class);
    }

    public function classroomExams()
    {
        return $this->belongsToMany(ClassroomExam::class, 'classroomexam_user', 'user_id', 'classroom_exam_id')
                    ->using(ClassExamUser::class)
                    ->withPivot([
                        'attempt',
                        'answers',
                        'waktu_mulai',
                        'waktu_selesai'
                    ]);
    }

    public function classExamUsers()
    {
        return $this->hasMany(ClassExamUser::class);
    }

    public function getExamScore($classExamId)
    {
        return $this->classroomExams()->where('classroom_exam_id', $classExamId)
                                        ->first()
                                        ->pivot->score();
    }

    public function hasDoneExam($classExamId)
    {
        return ($this->classroomExams()->where('classroom_exam_id', $classExamId)->get()->isNotEmpty()) ? true : false;
    }

}
