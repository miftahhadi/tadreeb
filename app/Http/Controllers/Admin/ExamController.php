<?php

namespace App\Http\Controllers\Admin;

use App\DataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UpdateExamRequest;
use App\Services\Admin\ExamService;
use App\Http\Requests\Admin\StoreExamRequest;
use App\Models\Classroom;
use App\Models\ClassroomExam;
use App\Models\Exam;
use Illuminate\Database\Eloquent\Builder;

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

        return view('admin.general.item-index', [
            'title' => 'Daftar Ujian',
            'fetchUrl' => '/api/ujian',
            'item' => 'ujian',
            'judul' => 'Judul ujian',
            'slug' => 'Slug URL',
            'action' => route('admin.ujian.store'),
            'tableHeading' => json_encode(DataTable::heading()),
            'itemProperties' => json_encode(DataTable::props()),
            'nameShownAs' => 'judul'
        ]);
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

        return view('admin.exam.show', [
            'title' => $ujian->judul . ' - Ujian ',
            'ujian' => $ujian,
            'questionTypes' => $this->service->questionTypes,
            'answerIcons' => $this->service->answerIcons
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
        if (is_null($request->input('kelas'))) {
            
            $data = [
                'mode' => 'classroomList',
                'heading' => ['Kelas', 'Grup'],
                'row' => $ujian->classrooms
            ];

        } elseif ($request->input('kelas')) {

            $classExam = ClassroomExam::with('users')->where([
                ['classroom_id', $request->input('kelas')],
                ['exam_id', $ujian->id]
            ])->first();

            $data = $classExam->dataToShow($request->input('done'));
            $data['kelas'] = $classExam->classroom;

        }

        return view('admin.exam.result', [
            'title' => 'Hasil - ' . $ujian->judul,
            'ujian' => $ujian,
            'data' => $data,
        ]);   
    }

}
