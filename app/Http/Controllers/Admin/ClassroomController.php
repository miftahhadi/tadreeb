<?php

namespace App\Http\Controllers\Admin;

use App\Classroom;
use App\Group;
use App\Http\Controllers\Controller;
use App\Services\Admin\ClassroomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ClassroomController extends Controller
{
    protected $classroomService;

    public function __construct(ClassroomService $classroomService)
    {
        $this->classroomService = $classroomService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd(Route::currentRouteName());
    }

    public function list(Group $grup) 
    {
        return response()->json($grup->classrooms()->paginate(15));
    }

    public function search($search)
    {
        return response()->json(Classroom::where('judul', 'like', '%' . $search . '%')
                                        ->orWhere('deskripsi', 'like', '%' .  $search . '%')
                                        ->paginate(15)
                );
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
    public function store(Request $request, Group $grup) 
    {
        $data = $request->validate([
            'judul' => '',
            'deskripsi' => ''
        ]);
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $grup, Classroom $kelas)
    {

        return view('admin.classroom.show', [
            'grup' => $grup,
            'kelas' => $kelas
        ]);
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
}
