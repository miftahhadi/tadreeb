<?php

namespace App\Http\Controllers\Front;

use App\Classroom;
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

    public function showHome(Classroom $classroom)
    {
        // $cardImage = Image::make(public_path('images/dBhITZK.jpg'));

        // $cardImage->crop();

        return view('front.kelas.home', [
            'title' => $classroom->nama,
            'kelas' => $classroom,
            'service' => $this->service
        ]);
    }

    public function showPeople(Classroom $classroom)
    {
        $people = $classroom->users()->get();

        return view('front.kelas.people', [
            'title' => 'Anggota - ' .  $classroom->nama,
            'kelas' => $classroom,
            'people' => $people,
            'service' => $this->service
        ]);
    }

    public function showLessons(Classroom $classroom)
    {
        $lessons = $classroom->lessons()->get();

        return view('front.kelas.lessons', [
            'title' => 'Pelajaran - ' . $classroom->nama,
            'kelas' => $classroom,
            'lessons' => $lessons,
            'service' => $this->service
        ]);
    }
}
