<?php

namespace App\Http\Controllers\Admin;

use App\Classroom;
use App\Group;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\Section;
use App\Services\Admin\ClassroomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ClassroomController extends Controller
{
    protected $classroomService;

    public function __construct(ClassroomService $classroomService)
    {
        $this->classroomService = $classroomService;
    }

    public function list(Group $grup) 
    {
        return response()->json($grup->classrooms()->paginate(25));
    }

    public function search($search)
    {
        return response()->json(Classroom::where('nama', 'like', '%' . $search . '%')
                                        ->orWhere('deskripsi', 'like', '%' .  $search . '%')
                                        ->paginate(25)
                );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Group $grup) 
    {
        $data = $request->validate([
            'judul' => '',
            'deskripsi' => ''
        ]);

        $kelas = $this->classroomService->store($data, $grup);

        return redirect(route('admin.grup.kelas.show', [$grup->id, $kelas->id]));
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $grup, Classroom $kelas)
    {
        $title = $kelas->nama . ' - ' . $grup->nama;

        $service = $this->classroomService->show($kelas);

        return view('admin.classroom.show', compact(
            'title', 'grup', 'kelas', 'service'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function lessonExamSetting(Group $group, Classroom $kelas, Lesson $pelajaran, Section $section, $exam)
    {
        $exam = $section->exams()->where('id', $exam);

        return view('admin.classroom.item-setting', [
            'title' => 'Pengaturan ' . $exam->judul,
            'group' => $group,
            'kelas' => $kelas,
            'pelajaran' => $pelajaran,
            'section' => $section,
            'exam' => $exam     
        ]);
    }
}
