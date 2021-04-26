<?php

namespace App\Services\Admin;

use App\Models\Classroom;
use App\Models\Examable;
use Illuminate\Support\Facades\DB;

class ShowExamResultService {

    public function __construct(Examable $examable) {
        $this->examable = $examable;
    }

    public function getResultsByClassroom($show)
    {
        $kelas = $this->examable->assignedTo();

        if (!$show || strtolower($show) == 'all') {
            $mode = 'showAll';
            $heading = ['Nama', 'Username', 'Sudah Mengerjakan?'];

            $users = $kelas->users->each(function ($user) {
                        return $user->has_done_exam = ($user->hasDoneExam($this->examable)) ? 1 : 0;
                    });
        } elseif (strtolower($show) == 'done') {
            $mode = 'showDone';
            $heading = ['Nama', 'Username', 'Waktu Mulai', 'Waktu Selesai', 'Nilai'];
            
            $users = $kelas->usersDoneExam($this->examable);
        } elseif (strtolower($show) == 'unfinished') {
            $mode = 'showNotDone';
            $heading = ['Nama', 'Username'];

            $users = $kelas->usersNotDoneExam($this->examable);
        }

        return [
            'mode' => $mode,
            'heading' => $heading,
            'row' => $users,
            'kelas' => $kelas
        ];
    }

}