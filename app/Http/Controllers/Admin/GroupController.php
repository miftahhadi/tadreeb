<?php

namespace App\Http\Controllers\Admin;

use App\Group;
use App\Http\Controllers\Controller;
use App\Services\Admin\GroupService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class GroupController extends Controller
{

    protected $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.general.index', [
            'item' => 'grup',
            'judul' => 'Nama Grup',
            'slug' => '',
            'url' => '',
            'action' => route('grup.store'),
            'tableHeading' => json_encode([
                [
                    'name' => 'Nama Grup',
                    'width' => ''
                ], 
            ]),
            'itemProperties' => json_encode(['id', 'nama'])
        ]);
    }

    public function list()
    {
        return response()->json(Group::paginate(10));
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
    public function store(Request $request)
    {
        $grup = $this->groupService->store($request->validate([
            'judul' => '',
            'deskripsi' => ''
        ]));

        return redirect(route('grup.show', $grup->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $grup)
    {
        return view('admin.grup.show', [
            'grup' => $grup,
            'item' => 'kelas',
            'judul' => 'Nama Kelas',
            'action' => '#',
            'url' => '',
            'slug' => ''
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
