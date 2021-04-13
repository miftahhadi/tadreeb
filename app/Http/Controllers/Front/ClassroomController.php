<?php

namespace App\Http\Controllers\Front;

use App\Models\Classroom;
use App\Http\Controllers\Controller;
use App\Services\Front\ClassroomService;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class ClassroomController extends Controller
{
    protected $service;

    public function __construct(ClassroomService $classroomService)
    {
        $this->service = $classroomService;
    }

    public function showHome(Classroom $kelas)
    {
        // $cardImage = Image::make(public_path('images/dBhITZK.jpg'));

        // $cardImage->crop();

        return view('front.kelas.home', [
            'title' => $kelas->nama,
            'kelas' => $kelas,
            'service' => $this->service
        ]);
    }

    public function showPeople(Classroom $kelas)
    {
        $people = $kelas->users()->get();

        return view('front.kelas.people', [
            'title' => 'Anggota - ' .  $kelas->nama,
            'kelas' => $kelas,
            'people' => $people,
            'service' => $this->service
        ]);
    }

    public function showLessons(Classroom $kelas)
    {
        $lessons = $kelas->lessons()->get();

        return view('front.kelas.lessons', [
            'title' => 'Pelajaran - ' . $kelas->nama,
            'kelas' => $kelas,
            'lessons' => $lessons,
            'service' => $this->service
        ]);
    }

    public function showWorks(Classroom $kelas)
    {
        $exams = $kelas->getActiveExamsByUser(auth()->user()->id);

        return view('front.kelas.exams', [
            'title' => 'Tugas dan Ujian - ' . $kelas->nama,
            'kelas' => $kelas,
            'exams' => $exams,
            'service' => $this->service
        ]);
    }
}
