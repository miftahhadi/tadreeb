<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Examable extends MorphPivot
{   
    protected $table = 'examables';

    protected $dates = [
        'tampil_otomatis',
        'buka_otomatis',
        'batas_buka',        
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'examable_user', 'examable_id', 'user_id')
                    ->using(ExamableUser::class)
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

    public function isOpen()
    {
        $now = now();

        if ($this->buka_otomatis) {
            $open = $now->greaterThanOrEqualTo($this->buka_otomatis);
        } else {
            $open = $this->buka;
        }

        return $open;
    }

    public function isClosed()
    {
        return !$this->isOpen();
    }

    public function getDurasiString()
    {
        return ($this->durasi) ? $this->durasi . ' menit'
                                : 'Tidak dibatasi';
    }

    public function getBatasBukaString()
    {
        if ($this->batas_buka instanceof Carbon) {
            return $this->batas_buka->tz(settings('timezone'))->format('d M Y H:i') . ' ' . settings('tzName');
        } else {
            return 'Tidak ada';
        }
    }    

}
