<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

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
