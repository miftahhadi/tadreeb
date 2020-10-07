<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UpdateExamRequest;
use App\Services\Admin\ExamService;
use App\Http\Requests\Admin\StoreExamRequest;
use App\Exam;


class ExamController extends Controller
{

    protected $examService;

    public function __construct(ExamService $examService)
    {
        $this->examService = $examService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.general.index', [
            'item' => 'ujian',
            'judul' => 'Judul ujian',
            'slug' => 'Slug URL',
            'action' => route('ujian.store'),
            'tableHeading' => json_encode([
                [
                    'name' => 'Judul',
                    'width' => '40%'
                ], 
                
                [
                    'name' => 'Slug',
                    'width' => null
                ]
            ]),
            'itemProperties' => json_encode(['id', 'judul', 'slug'])
        ]);
    }

    public function list() 
    {
        return response()->json(Exam::paginate(10));
    }

    public function search($search)
    {
        return response()->json(Exam::where('judul', 'like', '%' . $search . '%')
                                        ->orWhere('deskripsi', 'like', '%' .  $search . '%')
                                        ->paginate(10)
                );
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExamRequest $request)
    {
        $exam = $this->examService->createExam($request->validated());

        return redirect(route('ujian.show', ['ujian' => $exam->slug]));
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
            'ujian' => $ujian,
            'questionTypes' => $this->examService->questionTypes,
            'answerIcons' => $this->examService->answerIcons
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Exam  $ujian
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $ujian)
    {
        return view('admin.exam.edit', [
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
        $this->examService->update($request->validated(), $ujian);

        return redirect(route('ujian.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $ujian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $ujian)
    {
        $this->examService->delete($ujian);

        return redirect(route('ujian.index'));
    }
}
