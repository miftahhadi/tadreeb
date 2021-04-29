<?php

namespace App\Http\Controllers\Admin;

use App\Models\Classroom;
use App\Models\Group;
use App\Http\Controllers\Controller;
use App\Models\ClassroomExam;
use App\Models\Exam;
use App\Models\Lesson;
use App\Services\Admin\ShowClassroomService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClassroomController extends Controller
{
    protected $showClassroomService;

    public function __construct(ShowClassroomService $showClassroomService)
    {
        $this->showClassroomService = $showClassroomService;
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

        $kelas = $grup->classrooms()->create([
                    'nama' => $data['judul'],
                    'kode' => Str::random(10),
                    'deskripsi' => $data['deskripsi']
                ]);

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

        $page = $request->page;

        $itemName = $kelas->nama;
        $itemDescription = $kelas->deskripsi;

        $kelasUrl = route('admin.grup.kelas.show', ['grup' => $grup->id, 'kelas' => $kelas->id]);

        $service = $this->showClassroomService->show($kelas, $request);

        return view('admin.classroom.show', compact(
            'title', 'grup', 'kelas', 'service', 'page',
            'breadcrumbs', 'itemName', 'itemDescription',
            'kelasUrl'
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
