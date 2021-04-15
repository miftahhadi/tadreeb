<?php

namespace App\Services\Front;

use App\Models\Classroom;
use App\Models\Exam;
use App\Models\Examable;
use App\Models\ExamableUser;
use Carbon\Carbon;

class RecordExamService
{
    public $exam;
    public $classroom;
    public $examable;
    public $examableuser;

    protected $tz;
    protected $durasi;
    protected $batasBuka;

    public function hasDone()
    {
        // Pernah ngerjain belum?
        $attempts = $this->userHistory()->get()->count();

        if ($attempts > 1) {
            return true;
        } elseif ($attempts == 1) {
            $data = $this->userHistory()->first();

            return !is_null($data->waktu_selesai);
        }

    }

    public function canDoExam()
    {
        /* 
        * Cek data ujian dari table examables
        * 1) Jumlah Soal -- done
        * 2) Durasi -- done
        * 3) Attempt -- done
        * 4) Izin akses -- done
        * 
        * Ambil batas waktu akses dari database, ubah ke UTC +07:00
        * Terus cocokkan sama waktu sekarang
        * 
        * Cek peserta:
        * - Peserta diizinkan akses ujian?
        * - Peserta udah pernah ngerjain?
        *      (a) Belum pernah ngerjain?
        *          1) Catat waktu mulai ngerjakan: NOW --done
        *          2) Langsung masukkan ke database jawaban peserta dari nomor awal sampai akhir --done
        *          3) Catat attempt peserta --done
        *      (b) Udah pernah ngerjain?
        *          1) Cek attempt soal --done
        *          2) Kalau masih diizinkan, sama seperti (a) --done
        * 
        * Ambil id/urutan soal pertama -- done
        * Load soal serahkan ke elemen vue: lempar exam id ke vue -- done
         */
        
         if ($this->examable->isOpen()) {
            return $this->isUserAllowed();
        } else {
            return false;
        }

    }

    public function isUserAMember()
    {
        return $this->classroom->users()->find(auth()->user()->id) != null;
    }

    public function isUserAllowed()
    {
        // Dia anggota kelas bukan?
        // Udah pernah ngerjain belum?
        // Kalau udah, masih bisa ngerjain gak?

        if (!$this->isUserAMember()) {
            return false;
        }

        // Udah pernah mulai ngerjian?
        if ($this->userHistory()->get()->isEmpty()) {
            // Belum pernah, init data user
            $this->makeUserData();

            return true;
        }

        // Ambil data terakhir
        $this->examableuser = $this->userHistory()->first();

        // Sudah submit belum?
        // Kalau udah, masih punya kesempatan ujian?
        if ($this->examableuser->waktu_selesai) {
            if ($this->hasAttempt()) {
                $this->makeUserData();

                return true;
            } else {
                return false;
            }
        }

        return true;

    }

    public function hasAttempt()
    {
        return ($this->examable->attempt == 0 || $this->lastAttempt() < $this->examable->attempt);
    }

    public function userHistory()
    {
        return ExamableUser::where([
                                ['examable_id', $this->examable->id],
                                ['user_id', auth()->user()->id]
                            ])->orderBy('attempt', 'desc');
    }

    public function lastAttempt()
    {

        return $this->userHistory()->max('attempt') ?? 0;

    }

    public function newAttempt()
    {
        return $this->lastAttempt() + 1;
    }

    public function makeUserData()
    {
        // Rekam waktu_mulai user pakai UTC
        // Waktu mulai user dalam UTC
        $waktuMulai = Carbon::now('UTC');

        // Rekam data pengerjaan user
        $answers = [];

        foreach ($this->exam->questions()->get() as $question) {
            
            if ($question->tipe == 'Jawaban Ganda') {
                $answers[$question->id] = [
                    'answers' => [],
                    'score' => 0
                ];
            } else {
                $answers[$question->id] = [
                    'answers' => '',
                    'score' => 0
                ];
            }

        }

        $this->examableuser = ExamableUser::create([
            'classroom_exam_id' => $this->examable->id,
            'user_id' => auth()->user()->id,
            'attempt' => $this->newAttempt(),
            'answers' => json_encode($answers),
            'waktu_mulai' => $waktuMulai
        ]);

        return $this;

    }

    protected function questionsId()
    {
        return $this->exam->questions()
                            ->get()
                            ->pluck('id')
                            ->toArray();
    }

    public function getExamableUserId()
    {
        return $this->examableuser->id;    
    }
    
    public function getUserAnswers()
    {
        return $this->examableuser->answers;
    }

    public function isTimed()
    {
        return ($this->examable->durasi != 0);
    }

    public function examStart()
    {
        return $this->examableuser->waktu_mulai;
    }

    public function userExamExpires()
    {
        return $this->examStart()->addMinutes($this->examable->durasi);
    }

}