<?php

namespace App\Services\Front;

use App\Classroom;
use App\ClassroomExam;
use App\Exam;
use Carbon\Carbon;

class ClassroomExamService
{
    public $exam;
    public $classroom;
    public $classexam;

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
            $this->batasBuka = Carbon::createFromFormat('Y-m-d H:i:s',$this->classexam->batas_buka);
        }
    }

    public function batasBuka()
    {
        // Cek apakah batasBuka merupakan instance dari Carbon
        if ($this->batasBuka instanceof Carbon) {
            // Ubah dulu ke timezone sistem
            $this->batasBuka->tz($this->tz);

            // Berikan output berupa string datetime
            return $this->batasBuka->format('d M Y H:i');
        }
    }

    public function isAllowed()
    {
        // sementara true
        return true;
    }

    public function inExam(Exam $exam, Classroom $classroom)
    {

        $this->info($exam, $classroom);

        // Cek data ujian dari table classroom_exam
        // 1) Jumlah Soal -- done
        // 2) Durasi -- done
        // 3) Attempt
        // 4) Izin akses
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

        $now = Carbon::now('UTC');
        // $now->tz('+07:00');

        dd($now->tz);

    }

    public function initUser($attempt = 1, ClassroomExam $classexam)
    {
        // Rekam waktu_mulai user pakai UTC

        // Waktu mulai user dalam UTC
        $waktuMulai = Carbon::now('UTC');

        // Rekam data pengerjaan user
        $classexam->users()->attach(auth()->user()->id, [
            'attempt' => $attempt,
            'waktu_mulai' => $waktuMulai
        ]);

        return $this;

    }

}