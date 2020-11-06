<?php

namespace App\Services\Front;

use App\ClassExamUser;
use App\Classroom;
use App\ClassroomExam;
use App\Exam;
use Carbon\Carbon;

class ClassroomExamService
{
    public $exam;
    public $classroom;
    public $classexam;
    protected $classexamuser;

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
        //          1) Catat waktu mulai ngerjakan: NOW
        //          2) Langsung masukkan ke database jawaban peserta dari nomor awal sampai akhir
        //          3) Catat attempt peserta
        //      (b) Udah pernah ngerjain?
        //          1) Cek attempt soal
        //          2) Kalau masih diizinkan, sama seperti (a)
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
            return true;
        }

        // Ambil data terakhir
        $lastData = $this->userHistory()->first();

        // Sudah submit belum?
        // Kalau udah, masih punya kesempatan ujian?
        if ($lastData->waktu_selesai) {
            return $this->hasAttempt();
        }

        // Kalau belum, ujian ada durasinya gak?
        // - Gak ada, lanjut aja
        // - Ada, durasinya udah habis belum?
        if ($this->classexam->durasi != 0) {
            $waktuHabis = Carbon::createFromFormat('Y-m-d H:i:s',$lastData->waktu_mulai, 'UTC')
                                                ->addMinutes($this->classexam->durasi);

            $now = now('UTC');

            return $now->lessThan($waktuHabis);
        }

        // Default true
        return true;

    }

    public function hasAttempt()
    {
        return ($this->lastAttempt() < $this->classexam->attempt);
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

    public function thisAttempt()
    {
        return $this->lastAttempt() + 1;
    }

    public function initUser($attempt = 1)
    {
        // Rekam waktu_mulai user pakai UTC
        // Waktu mulai user dalam UTC
        $waktuMulai = Carbon::now('UTC');

        // Rekam data pengerjaan user
        $answers = [];

        foreach ($this->questionsId() as $question) {
            $answers[$question] = [
                'answers' => [],
                'score' => 0
            ];
        }

        $this->classexam->users()->attach(auth()->user()->id, [
            'attempt' => $attempt,
            'answers' => json_encode($answers),
            'waktu_mulai' => $waktuMulai,
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

}