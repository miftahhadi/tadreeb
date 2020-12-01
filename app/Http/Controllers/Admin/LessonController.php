<?php

namespace App\Http\Controllers\Admin;

use App\DataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Http\Requests\Admin\StoreLessonRequest;
use App\Http\Requests\Admin\UpdateLessonRequest;
use App\Services\Admin\LessonService;

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
            'title' => 'Daftar Pelajaran',
            'fetchUrl' => '/api/pelajaran',
            'item' => 'pelajaran',
            'judul' => 'Judul pelajaran',
            'slug' => 'Slug URL',
            'action' => route('admin.pelajaran.store'),
            'tableHeading' => json_encode(DataTable::heading()),
            'itemProperties' => json_encode(DataTable::props())
        ]);
    }

    public function list()
    {
        return response()->json(Lesson::paginate(10));
    }

    public function search($search)
    {
        return response()->json(Lesson::where('judul', 'like', '%' . $search . '%')
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
    public function store(StoreLessonRequest $request)
    {
        $lesson = $this->lessonService->createLesson($request->validated());

        return redirect(route('admin.pelajaran.show', $lesson->slug));
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\Lesson $pelajaran
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $pelajaran)
    {
        $sections = $pelajaran->sections;

        return view('admin.lesson.show', [
            'title' => $pelajaran->judul . ' - Pelajaran ',
            'pelajaran' => $pelajaran,
            'sections' => $sections, 
            'item' => 'section',
            'judul' => 'Judul section',
            'action' => route('admin.section.store', [ 'pelajaran' => $pelajaran->slug ])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Lesson $pelajaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $pelajaran)
    {
        return view('admin.lesson.edit', [
            'title' => 'Edit ' . $pelajaran->judul . ' - Pelajaran ',
            'pelajaran' => $pelajaran
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Lesson $pelajaran
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLessonRequest $request, Lesson $pelajaran)
    {
        $this->lessonService->update($request->validated(), $pelajaran);

        return redirect(route('admin.pelajaran.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Lesson $pelajaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $pelajaran)
    {
        $this->lessonService->destroy($pelajaran);

    }
}
