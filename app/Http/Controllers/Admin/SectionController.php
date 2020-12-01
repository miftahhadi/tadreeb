<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\SectionContent;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function store(Lesson $pelajaran, Request $request) 
    {
        $data = $request->validate([
            'judul' => 'required',
            'deskripsi' => ''
        ]);

        $section = $pelajaran->sections()
                                ->create($data);

        return redirect(route('admin.section.show', [
            'pelajaran' => $pelajaran->slug,
            'section' => $section->id
        ]));
    }

    public function show(Lesson $pelajaran, Section $section)
    {

        $assignedExams = $section->exams;
        $assignExamUrl = "/api/section/$section->id/ujian/assign";

        return view('admin.section.show', [
            'title' => $section->judul . ' - ' .  $pelajaran->judul,
            'pelajaran' => $pelajaran,
            'section' => $section,
            'assignExamUrl' => $assignExamUrl,
            'assignedExams' => $assignedExams,

        ]);
    }

}
