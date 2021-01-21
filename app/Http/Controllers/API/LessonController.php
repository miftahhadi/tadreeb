<?php

namespace App\Http\Controllers\API;

use App\Models\Classroom;
use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        return response()->json(Lesson::paginate(10));
    }

    public function search($search)
    {
        return response()->json(
            Lesson::where('judul', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' .  $search . '%')
                    ->paginate(10)
        );
    }

    public function getSlug(Request $request)
    {
        $slug = $request['slug'];

        $lesson = Lesson::where('slug', $slug)->first();

        return ($lesson) ? true : false;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return 'yes';
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
    public function destroy(Lesson $pelajaran)
    {
        return $pelajaran->delete();
    }

}
