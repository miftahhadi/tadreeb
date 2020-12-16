<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassroomExam extends Pivot
{
    protected $dates = [
        'tampil_otomatis',
        'buka_otomatis',
        'batas_buka',
        
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'classroomexam_user', 'classroom_exam_id', 'user_id')
                    ->using(ClassExamUser::class)
                    ->withPivot([
                        'attempt', 
                        'answers',
                        'waktu_mulai', 
                        'waktu_selesai'
                    ]);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function dataToShow($done = null)
    {
        if ($done && $done == 'true') {

            $users = $this->classroom->usersDoneExam($this->id);

            $heading = ['Nama', 'Username', 'Waktu Mulai', 'Waktu Selesai', 'Nilai'];

            $mode = 'showDone';

        } elseif ($done && $done == 'false') {
            $users = $this->classroom->usersNotDoneExam($this->id);

            $heading = ['Nama', 'Username'];

            $mode = 'showNotDone';
       
        } else {
            $mode = 'showAll';

            $heading = ['Nama', 'Username', 'Sudah Mengerjakan?'];

            $id = $this->id;

            $users = $this->classroom
                                ->users
                                ->each(function ($user) use ($id) {
                                    $user->doneExam = $user->hasDoneExam($id);
                                });
        }

        return [
            'mode' => $mode,
            'heading' => $heading,
            'row' => $users
        ];
    }

}
