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
                            $toShow['status'] = $user->examStatus($exam->pivot->id);

                            return $toShow;
                        })
                        ->toArray();
    }
}
