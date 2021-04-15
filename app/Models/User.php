<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

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
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getRoleDisplayName()
    {
        return $this->role->display_as;
    }

    public function assignRole($role)
    {
        if (is_numeric($role)) {
            $role = Role::find($role);
        } else {
            $role = Role::where('name', $role)->first();
        }

        if (!$role) {
            return false;
        }

        return $this->role()->associate($role)->save();
    }

    public function canAccessAdmin()
    {
        $hasAccess = collect(['admin', 'superadmin']);

        return $hasAccess->contains($this->role->name);
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

    public function examables()
    {
        return $this->belongsToMany(Examable::class, 'examable_user', 'user_id', 'examable_id')
                    ->using(ExamableUser::class)
                    ->withPivot([
                        'attempt',
                        'answers',
                        'waktu_mulai',
                        'waktu_selesai'
                    ]);
    }

    // public function classExamUsers()
    // {
    //     return $this->hasMany(ClassExamUser::class);
    // }

    // public function getExamScore($classExamId)
    // {
    //     return $this->classroomExams()->where('classroom_exam_id', $classExamId)
    //                                     ->first()
    //                                     ->pivot->score();
    // }

    public function hasDoneExam($examableId) // Masih error
    {
        return $this->examables()->where('examable.id', $examableId)->get()->isNotEmpty();
    }

    public function examStatus($examableId)
    {
        $examable = $this->examables()->find($examableId);

        if (!$examable) {
            return 'Belum mengerjakan';
        }

        $examableUser = $examable->pivot;

        if ($examableUser->waktu_mulai && $examable->isClosed()) {
            return 'Tidak selesai';
        }

        return ($examableUser->waktu_selesai) ? 'Sudah mengerjakan' : 'Sedang mengerjakan';
    }
}
