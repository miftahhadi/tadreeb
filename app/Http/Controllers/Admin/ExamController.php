<?php

namespace App\Http\Controllers\Admin;

use App\DataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UpdateExamRequest;
use App\Services\Admin\ExamService;
use App\Http\Requests\Admin\StoreExamRequest;
use App\Models\Exam;

class ExamController extends Controller
{

    protected $service;

    public function __construct(ExamService $examService)
    {
        $this->service = $examService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [];

        $title = 'Daftar Ujian';
        $fetchUrl = '/api/ujian';
        $item = 'ujian';
        $judul = 'Judul ujian';
        $tableHeading = json_encode(DataTable::heading());
        $itemProperties = json_encode(DataTable::props());
        $nameShownAs = 'judul';

        return view('admin.general.item-index', compact(
            'breadcrumbs','title', 'fetchUrl', 'item', 'judul',
            'tableHeading', 'itemProperties',
            'nameShownAs' 
        ));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExamRequest $request)
    {
        $exam = $this->service->createExam($request->validated());

        return redirect(route('admin.ujian.show', ['ujian' => $exam->slug]));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $ujian
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $ujian)
    {
        $breadcrumbs = [
            [
                'name' => 'Ujian',
                'href' => route('admin.ujian.index')
            ]
        ];

        $itemName = $ujian->judul;
        $itemDescription = $ujian->deskripsi;
        
        $questions = $ujian->questions->map(function ($question) {
            return [
                'id' => $question->id,
                'kode' => $question->kode,
                'urutan' => $question->pivot->urutan,
                'konten' => $question->konten,
                'tipe' => $question->tipe,
                'answers' => $question->answers
            ];
        });

        return view('admin.exam.show', [
            'title' => $ujian->judul . ' - Ujian ',
            'ujian' => $ujian,
            'questions' => $questions,
            'questionTypes' => $this->service->questionTypes,
            'answerIcons' => $this->service->answerIcons,
            'breadcrumbs' => $breadcrumbs,
            'itemName' => $itemName,
            'itemDescription' => $itemDescription
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Exam  $ujian
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $ujian)
    {
        return view('admin.exam.edit', [
            'title' => 'Edit ' . $ujian->judul . ' - Ujian ', 
            'ujian' => $ujian
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $ujian
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExamRequest $request, Exam $ujian)
    {
        $this->service->update($request->validated(), $ujian);

        return redirect(route('admin.ujian.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $ujian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $ujian)
    {
        $this->service->delete($ujian);

        return redirect(route('admin.ujian.index'));
    }

    public function showResult(Exam $ujian, Request $request)
    {
        $breadcrumbs = [
            [
                'name' => 'Ujian',
                'href' => route('admin.ujian.index')
            ]
        ];

        $itemName = $ujian->judul;
        $itemDescription = $ujian->deskripsi;

        if (is_null($request->input('kelas'))) {
            
            $data = [
                'mode' => 'classroomList',
                'heading' => ['Kelas', 'Grup'],
                'row' => $ujian->classrooms
            ];

        } elseif ($request->input('kelas')) {

            // $examable = $ujian->classrooms()->find($request->input('kelas'))->pivot;
            $kelas = $ujian->classrooms()->find($request->input('kelas'));
            $examable = $kelas->pivot;
            
            $done = $request->input('done');

            if ($done && $done == 'true') {

                $users = $kelas->usersDoneExam($examable->id);
    
                $heading = ['Nama', 'Username', 'Waktu Mulai', 'Waktu Selesai', 'Nilai'];
    
                $mode = 'showDone';
    
            } elseif ($done && $done == 'false') {
                $users = $kelas->usersNotDoneExam($examable->id);
    
                $heading = ['Nama', 'Username'];
    
                $mode = 'showNotDone';
           
            } else {
                $mode = 'showAll';
    
                $heading = ['Nama', 'Username', 'Sudah Mengerjakan?'];
    
                $id = $examable->id;
    
                $users = $kelas
                                    ->users
                                    ->each(function ($user) use ($id) {
                                        $user->doneExam = $user->hasDoneExam($id);
                                    });
            }

            $data = [
                'mode' => $mode,
                'heading' => $heading,
                'row' => $users,
                'kelas' => $kelas
            ];

        }

        return view('admin.exam.result', [
            'title' => 'Hasil - ' . $ujian->judul,
            'breadcrumbs' => $breadcrumbs,
            'itemName' => $itemName,
            'itemDescription' => $itemDescription,
            'ujian' => $ujian,
            'data' => $data,
        ]);   
    }

    public function showClassrooms(Exam $ujian, Request $request)
    {
        if ($request->input('page') && $request->input('page') == 'hasil') {
            return $this->showResult($ujian, $request);
        }

        $breadcrumbs = [
            [
                'name' => 'Ujian',
                'href' => route('admin.ujian.index')
            ]
        ];

        $itemName = $ujian->judul;
        $itemDescription = $ujian->deskripsi;

        $tableHeading = json_encode(DataTable::heading(3));
        $itemProperties = json_encode(DataTable::props(3));

        return view('admin.exam.kelas', [
            'breadcrumbs' => $breadcrumbs,
            'itemName' => $itemName,
            'itemDescription' => $itemDescription,
            'ujian' => $ujian,
            'title' => $ujian->judul,
            'tableHeading' => $tableHeading,
            'itemProperties' => $itemProperties
        ]);
    }

}
