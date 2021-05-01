<?php

namespace App\Services\Admin;

use App\Models\Classroom;
use App\Models\Examable;
use Illuminate\Support\Facades\DB;

class ShowExamResultService {

    public function __construct(Examable $examable) {
        $this->examable = $examable;
    }

    public function getResultsByClassroom()
    {
        $kelas = $this->examable->assignedTo();
        $users = $kelas->users()
                        ->select('users.id', 'users.name', 'users.username')
                        ->orderBy('classroom_user.id')
                        ->get()
                        ->each(function ($user) {
                            if ($user->examables()->where('examables.id', $this->examable->id)) {
                                return $user->examData = $this->examable->getUserLastRecord($user->id);
                            }
                        })->map(function ($user) {
                            $userData = [
                                'id' => $user->id,
                                'name' => $user->name,
                                'username' => $user->username,
                            ];

                            if ($user->examData) {
                                $userData['has_done_exam'] = 'Sudah';
                                $userData['waktu_mulai'] = $user->examData->getWaktuMulaiString();
                                $userData['score'] = $user->examData->score;
                            } else {
                                $userData['has_done_exam'] = 'Belum';
                            }

                            return $userData;
                        });

        return [
            'row' => $users,
            'kelas' => $kelas,
            'mode' => 'users-list'
        ];
    }

}