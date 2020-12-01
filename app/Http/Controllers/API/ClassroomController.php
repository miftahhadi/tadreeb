<?php

namespace App\Http\Controllers\API;

use App\Models\Classroom;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{

    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function destroy($id)
    {
        //
    }

    public function lesson(Classroom $kelas)
    {
        return json_encode($kelas->lessons()->paginate(20));
    }

    public function assignLesson(Classroom $kelas, Request $request)
    {
        $pelajaran = $request->input('itemId');

        return $kelas->lessons()->toggle($pelajaran);
    }

    public function exam(Classroom $kelas)
    {
        return json_encode($kelas->exams()->paginate(20));
    }

    public function assignExam(Classroom $kelas, Request $request)
    {
        $ujian = $request->input('itemId');

        return $kelas->exams()->toggle($ujian);
    }

    public function user(Classroom $kelas)
    {
        return json_encode($kelas->users()->paginate(20));
    }

    public function assignUser(Classroom $kelas, Request $request)
    {
        $ujian = $request->input('itemId');

        return $kelas->users()->toggle($ujian);
    }
}
