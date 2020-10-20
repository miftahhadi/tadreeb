<?php

namespace App\Http\Controllers\Admin;

use App\DataTable;
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
            'fetchUrl' => '/api/grup',
            'item' => 'grup',
            'judul' => 'Nama Grup',
            'slug' => '',
            'action' => route('admin.grup.store'),
            'tableHeading' => json_encode(DataTable::heading(2)),
            'itemProperties' => json_encode(DataTable::props(2))
        ]);
    }

    public function list()
    {
        return response()->json(Group::paginate(10));
    }

    public function search($search)
    {
        return response()->json(Group::where('judul', 'like', '%' . $search . '%')
                                        ->orWhere('deskripsi', 'like', '%' .  $search . '%')
                                        ->paginate(10)
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
    public function store(Request $request)
    {
        $grup = $this->groupService->store($request->validate([
            'judul' => '',
            'deskripsi' => ''
        ]));

        return redirect(route('admin.grup.show', $grup->id));
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
            'fetchUrl' => '/api/grup/' . $grup->id . '/kelas',
            'grup' => $grup,
            'item' => 'kelas',
            'judul' => 'Nama Kelas',
            'action' => route('admin.grup.kelas.store', $grup->id),
            'slug' => '',

            'tableHeading' => json_encode(DataTable::heading(3)),
            'itemProperties' => json_encode(DataTable::props(3)),

            'itemUrl' => '/admin/grup/' . $grup->id . '/kelas/',
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
