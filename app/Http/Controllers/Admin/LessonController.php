<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lesson;
use App\Http\Requests\Admin\StoreLessonRequest;
use App\Http\Requests\Admin\UpdateLessonRequest;
use App\Services\Admin\LessonService;
use Symfony\Component\HttpFoundation\Response;

class LessonController extends Controller
{

    protected $lessonService;

    public function __construct(LessonService $lessonService)
    {
        $this->lessonService = $lessonService;
    }


    public function index()
    {
        return view('admin.general.index', [
            'item' => 'pelajaran',
            'judul' => 'Judul pelajaran',
            'slug' => 'Slug URL',
            'url' => $_SERVER['SERVER_NAME'] . '/k/{kelas}/u',
            'action' => route('pelajaran.store'),
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
        return response()->json(Lesson::paginate(10));
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
        return view('admin.lesson.edit', [
            'pelajaran' => $pelajaran
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Lesson $pelajaran
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLessonRequest $request, Lesson $pelajaran)
    {
        $this->lessonService->update($request->validated(), $pelajaran);

        return redirect(route('pelajaran.index'));
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
