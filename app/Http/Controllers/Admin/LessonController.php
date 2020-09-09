<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lesson;
use App\Http\Requests\Admin\StoreLessonRequest;
use App\Services\Admin\LessonService;

class LessonController extends Controller
{

    protected $lessonService;

    public function __construct(LessonService $lessonService)
    {
        $this->lessonService = $lessonService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.lesson.index', [
            'lessons' => Lesson::all(),
            'item' => 'pelajaran',
            'judul' => 'Judul pelajaran',
            'slug' => 'Slug URL',
            'url' => $_SERVER['SERVER_NAME'] . '/k/{kelas}/u',
            'action' => route('pelajaran.store')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function store(StoreLessonRequest $request)
    {
        $lesson = $this->lessonService->createLesson($request->validated());

        return redirect(route('pelajaran.show', $lesson->slug));
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Lesson $pelajaran
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $pelajaran)
    {
        return view('admin.lesson.show', [
            'pelajaran' => $pelajaran
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Lesson $pelajaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $pelajaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Lesson $pelajaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $pelajaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Lesson $pelajaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $pelajaran)
    {
        $this->lessonService->destroy($pelajaran);

        return redirect(route('pelajaran.index'));
    }
}
