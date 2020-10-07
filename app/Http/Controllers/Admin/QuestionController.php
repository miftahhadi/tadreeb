<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\QuestionService;
use App\Http\Requests\Admin\StoreQuestionRequest;
use App\Http\Requests\Admin\UpdateQuestionRequest;
use App\Exam;
use App\Question;

class QuestionController extends Controller
{
    protected $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Exam $ujian)
    {
        $questionForm = $this->questionService->createQuestionForm($request);

        return view('admin.question.create', [
            'ujian' => $ujian,
            'choices' => $questionForm['choices'],
            'value' => $questionForm['value'] ?? '',
            'option' => $questionForm['option']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request, Exam $ujian)
    {

        $this->questionService->simpanSoal($request, $ujian);

        return redirect(route('admin.ujian.show', $ujian->slug));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $ujian, Question $soal)
    {
        return view('admin.question.edit',[
            'ujian' => $ujian,
            'soal' => $soal,
            'option' => $this->questionService->option($soal)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Question  $soal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionRequest $request, Exam $ujian, Question $soal)
    {
        $this->questionService->update($request->validated(), $soal);

        return redirect(route('admin.ujian.show', $ujian->slug));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $soal)
    {
        $soal->delete();

        return redirect(route('admin.ujian.index')); // TODO: buat route ke bank soal
    }


    public function unassignFromExam(Exam $ujian, Question $soal)
    {
        $ujian->questions()->detach($soal->id);

        return redirect(route('admin.ujian.show', $ujian->slug));
    }
}
