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
        'created_at',
        'updated_at'        
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'examable_user', 'examable_id', 'user_id')
                    ->using(ExamableUser::class)
                    ->withPivot([
                        'id',
                        'attempt', 
                        'answers',
                        'waktu_mulai', 
                        'waktu_selesai'
                    ])
                    ->withTimestamps();
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function examableuser()
    {
        return $this->hasMany(ExamableUser::class);
    }

    public function assignedTo()
    {
        return $this->examable_type::find($this->examable_id);
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

    public function isTimed()
    {
        return $this->durasi != 0;
    }

    public function isOpen()
    {
        $now = now();
        $open = $this->buka;

        if ($this->buka_otomatis && $this->batas_buka) {
            $open = $now->greaterThanOrEqualTo($this->buka_otomatis) && $now->lessThanOrEqualTo($this->batas_buka);
        } elseif ($this->buka_otomatis) {
            $open = $now->greaterThanOrEqualTo($this->buka_otomatis);
        } elseif ($this->batas_buka) {
            $open = $now->lessThanOrEqualTo($this->batas_buka);
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

    public function isUserAllowed(User $user)
    {
        // Gimana pun ceritanya, kalau akses ditutup user gak boleh buka
        if ($this->isClosed()) {
            return false;
        }

        // Udah pernah ngerjain?
        $lastRecord = $this->getUserLastRecord($user->id);

        // -- Belum pernah ngerjain, boleh ngerjain
        if (!$lastRecord) {
            return true;
        }

        // -- Udah pernah ngerjain, masih boleh ngerjain?        
        // Udah submit jawaban atau belum?
        if ($lastRecord->waktu_selesai) {

            // --> Ada, masih punya kesempatan?
            return $this->isUserHasAttempt($lastRecord);
        
        } else if ($this->durasi && $this->durasi > 0) {
            // --> Gak ada, durasi udah habis belum?
            $now = now();
            $waktuHabis = $lastRecord->waktu_mulai->addMinutes($this->durasi);

            return $now->lessThan($waktuHabis);
        
        } else {
            return true;
        }

    }

    public function isUserHasAttempt(ExamableUser $record)
    {
        return $this->attempt == 0 || $record->attempt < $this->attempt;
    }

    public function userLastAttempt($userId)
    {
        if ($records = $this->getUserRecords($userId)) {
            return $records->max('attempt');
        } else {
            return null;
        }
    }

    public function attemptRemaining($userId)
    {
        if (!$this->attempt || $this->attempt == 0) {
            return 'infinite';
        }

        else if ($last = $this->userLastAttempt($userId)) {
            return $this->attempt - $last;
        }
    }

    public function getUserRecords($userId)
    {
        $data = $this->users()->where('users.id', $userId)
                             ->get();
        
        if ($data->isNotEmpty()) {
            $records = $data->map(function ($item) {
                        return $item->pivot;
                    });
            
            return $records;
        } else {
            return null;
        }
    }

    public function getUserLastRecord($userId)
    {
        if ($records = $this->getUserRecords($userId)) {
            return $records->sortByDesc('attempt')
                            ->first();
        } else {
            return null;
        }
    }

    public function getUserLastFinishedRecord($userId)
    {
        if ($records = $this->getUserRecords($userId)) {
            return $records->whereNotNull('waktu_selesai')
                            ->sortByDesc('attempt')
                            ->first();
        } else {
            return null;
        }
    }

    public function getUserRecordByAttempt($userId, $attempt)
    {
        return $this->users()->where('users.id', $userId)
                                ->get()
                                ->filter(function ($data) use ($attempt) {
                                    return $data->pivot->attempt == $attempt;
                                })
                                ->first()
                                ->pivot;
    }

}
