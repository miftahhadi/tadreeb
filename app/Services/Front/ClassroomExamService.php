<?php

namespace App\Services\Front;

use App\Models\ClassExamUser;
use App\Models\Classroom;
use App\Models\ClassroomExam;
use App\Models\Exam;
use Carbon\Carbon;

class ClassroomExamService
{
    public $exam;
    public $classroom;
    public $classexam;
    public $classexamuser;

    protected $tz;
    protected $durasi;
    protected $batasBuka;

    public function __construct()
    {
        $this->tz = settings('timezone');
    }

    public function info(Exam $exam, Classroom $classroom)
    {
        $this->exam = $exam;
        $this->classroom = $classroom;

        $this->classexam = ClassroomExam::where([
                                ['classroom_id', $classroom->id],
                                ['exam_id', $exam->id]
                            ])
                            ->first();

        $this->exam->loadCount('questions');

        $this->setDurasi();
        $this->setBatasBuka();

        return $this;
    }

    public function questionsCount()
    {
        return $this->exam->questions_count;
    }

    public function setDurasi()
    {   
        $this->durasi = ($this->classexam->durasi != 0) 
                                ? $this->classexam->durasi . ' menit' 
                                : 'Tidak dibatasi';
    }

    public function durasi()
    {
        return $this->durasi;
    }

    public function setBatasBuka()
    {
        if ($this->classexam->batas_buka) {
            $this->batasBuka = Carbon::createFromFormat('Y-m-d H:i:s', $this->classexam->batas_buka, 'UTC');
        }
    }

    public function batasBuka()
    {
        // Cek apakah batasBuka merupakan instance dari Carbon
        if ($this->batasBuka instanceof Carbon) {
            // Ubah dulu ke timezone sistem
            $this->batasBuka->tz($this->tz);

            // Berikan output berupa string datetime
            return $this->batasBuka->format('d M Y H:i') . ' ' . settings('tzName');
        } else {
            return 'Tidak ada';
        }
    }

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

        // Cek data ujian dari table classroom_exam
        // 1) Jumlah Soal -- done
        // 2) Durasi -- done
        // 3) Attempt -- done
        // 4) Izin akses -- done
        // 
        // Ambil batas waktu akses dari database, ubah ke UTC +07:00
        // Terus cocokkan sama waktu sekarang
        //
        // Cek peserta:
        // - Peserta diizinkan akses ujian?
        // - Peserta udah pernah ngerjain?
        //      (a) Belum pernah ngerjain?
        //          1) Catat waktu mulai ngerjakan: NOW --done
        //          2) Langsung masukkan ke database jawaban peserta dari nomor awal sampai akhir --done
        //          3) Catat attempt peserta --done
        //      (b) Udah pernah ngerjain?
        //          1) Cek attempt soal --done
        //          2) Kalau masih diizinkan, sama seperti (a) --done
        // 
        // Ambil id/urutan soal pertama -- done
        // Load soal serahkan ke elemen vue: lempar exam id ke vue -- done

        if ($this->isExamOpen()) {
            return $this->isUserAllowed();
        } else {
            return false;
        }

    }

    public function isExamOpen()
    {
        if ($this->classexam->buka == 0) {
            return false;
        }

        if ($this->batasBuka) {
            
            // Ambil waktu sekarang, set ke UTC
            $now = now('UTC');

            return $now->lessThan($this->batasBuka);

        }

        return true;

    }

    public function isUserAllowed()
    {
        // Dia anggota kelas bukan?
        // Udah pernah ngerjain belum?
        // Kalau udah, masih bisa ngerjain gak?

        $memberIds = $this->classroom->users()->get()->pluck('id')->toArray();

        if (!in_array(auth()->user()->id, $memberIds)) {
            return false;
        }

        // Udah pernah mulai ngerjian?
        if ($this->userHistory()->get()->isEmpty()) {
            // Belum pernah, init data user
            $this->initUser();

            return true;
        }

        // Ambil data terakhir
        $this->classexamuser = $this->userHistory()->first();

        // Sudah submit belum?
        // Kalau udah, masih punya kesempatan ujian?
        if ($this->classexamuser->waktu_selesai) {
            if ($this->hasAttempt()) {
                $this->initUser();

                return true;
            } else {
                return false;
            }
        }

        // Kalau belum, ujian ada durasinya gak?
        // - Gak ada, lanjut aja

        // - Ada
        // Serahkan ke JS
        /* if ($this->isTimed()) { 
            $waktuHabis = $this->userExamExpires();

            $now = now('UTC');

            if ($now->greaterThanOrEqualTo($waktuHabis) && $this->hasAttempt()) { 
                // Waktu habis dan masih punya kesempatan
                $this->initUser();

                return true;
            } elseif ($now->lessThan($waktuHabis)) {
                // Waktu belum habis
                return true;
            } else {
                // Waktu habis dan kesempatan udah habis
                return false;
            }
        } */

        // Default true
        return true;

    }

    public function hasAttempt()
    {
        return ($this->classexam->attempt == 0 || $this->lastAttempt() < $this->classexam->attempt);
    }

    public function userHistory()
    {
        return ClassExamUser::where([
                                ['classroom_exam_id', $this->classexam->id],
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

    public function initUser()
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

        $this->classexamuser = ClassExamUser::create([
            'classroom_exam_id' => $this->classexam->id,
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

    public function getClassExamUserId()
    {
        return $this->classexamuser->id;    
    }
    
    public function getUserAnswers()
    {
        return $this->classexamuser->answers;
    }

    public function isTimed()
    {
        return ($this->classexam->durasi != 0);
    }

    public function examStart()
    {
        return $this->classexamuser->waktu_mulai;
    }

    public function userExamExpires()
    {
        return $this->examStart()->addMinutes($this->classexam->durasi);
    }

}