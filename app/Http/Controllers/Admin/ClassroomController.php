<?php

namespace App\Http\Controllers\Admin;

use App\Models\Classroom;
use App\Models\Group;
use App\Http\Controllers\Controller;
use App\Models\ClassroomExam;
use App\Models\Exam;
use App\Models\Lesson;
use App\Models\Section;
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
    public function show(Group $grup, Classroom $kelas, Request $request)
    {
        $title = $kelas->nama . ' - ' . $grup->nama;

        $service = $this->classroomService->show($kelas);

        $breadcrumbs = [
            [
                'name' => 'Grup & Kelas',
                'href' => route('admin.grup.index')
            ],
            [
                'name' => $grup->nama,
                'href' => route('admin.grup.show', $grup->id)
            ]
        ];

        $itemName = $kelas->nama;
        $itemDescription = $kelas->deskripsi;

        return view('admin.classroom.show', compact(
            'title', 'grup', 'kelas', 'service', 'breadcrumbs', 'itemName', 'itemDescription'
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

    public function showExamResult(Group $grup, Classroom $kelas, Exam $exam, Request $request)
    {
        $classExam = ClassroomExam::where([
            ['classroom_id', $kelas->id],
            ['exam_id', $exam->id]
        ])->fist();

        $data = $classExam->dataToShow($request->input('done'));
        $data['kelas'] = $kelas;

        return view('admin.classroom.exam-result', [
            'title' => 'Hasil ' . $exam->judul . ' - ' . 'Kelas ' . $kelas->nama,
            'grup' => $grup,
            'kelas' => $kelas,
            'ujian' => $exam,
            'data' => $data 
        ]);
    }


}
