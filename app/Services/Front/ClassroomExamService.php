<?php

namespace App\Services\Front;

use App\Exam;

class ClassroomExamService
{
    protected $questionsCount;

    public function info(Exam $exam)
    {
        $exam->loadCount('questions');

        $this->questionsCount = $exam->questions_count;
    }

    public function jumlahSoal()
    {
        return $this->questionsCount;
    }

    public function inExam()
    {
        // Cek data ujian dari table classroom_exam
        // 1) Jumlah Soal
        // 2) Durasi
        // 3) Attempt
        // 4) Izin akses
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
        // Ambil id/urutan soal pertama
        // Load soal serahkan ke elemen vue: lempar exam id ke vue
    }

}