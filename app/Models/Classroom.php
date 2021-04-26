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

    /* public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    } */

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

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function isUserAMember($userId)
    {
        return $this->users()->where('user_id', $userId)->count() > 0;
    }

    public function usersDoneExam(Examable $examable)
    {
        return $this->users
                        ->filter(function ($user) use ($examable) {
                            return $user->hasDoneExam($examable);
                        })->each(function ($user) use ($examable) {
                            return $user->examData = $examable->getUserLastFinishedRecord($user->id);
                        });
    }

    public function usersNotDoneExam($examable)
    {
        return $this->users
                        ->filter(function ($user) use ($examable) {
                            return !$user->hasDoneExam($examable);
                        });
    }

    public function getActiveExamsByUser($userId, $take = null)
    {
        $now = now('utc');
        $user = User::find($userId);

        $query = $this->exams()->orderBy('examables.id', 'desc');

        if ($take != null) {
            $query = $query->take($take);
        }

        return $query->get()
                        ->filter(function($exam) use ($now) {
                            $hidden = ($exam->pivot->tampil == 1) ? 0 : 1;

                            if ($exam->pivot->tampil_otomatis) {
                                $hidden = ($now->greaterThanOrEqualTo($exam->pivot->tampil_otomatis)) ? 0 : 1;
                            }

                            return ($hidden == 0);
                        })
                        ->map(function($exam) use ($now, $user) {
                            $toShow = [
                                'examable_id' => $exam->pivot->id,
                                'id' => $exam->id,
                                'judul' => $exam->judul,
                                'slug' => $exam->slug
                            ];

                            $toShow['buka'] = $exam->pivot->isOpen();
                            $toShow['status'] = $user->examStatus($exam->pivot);

                            return $toShow;
                        })
                        ->toArray();
    }
}
