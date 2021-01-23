<?php

namespace App\Http\Controllers\Admin;

use App\DataTable;
use App\Models\Group;
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
        $breadcrumbs = [];

        $title = 'Grup User';
        $fetchUrl = '/api/grup';
        $item = 'grup';
        $judul = 'Nama Grup';
        $tableHeading = json_encode(DataTable::heading(2));
        $itemProperties = json_encode(DataTable::props(2));
        $nameShownAs = 'nama';

        return view('admin.general.item-index', compact(
            'breadcrumbs','title', 'fetchUrl', 'item', 'judul', 'tableHeading', 'itemProperties', 'nameShownAs'
        ));
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
        $title = $grup->nama . ' - Grup User ';
        $fetchUrl = '/api/grup/' . $grup->id . '/kelas';
        $item = 'kelas';
        $judul = 'Nama Kelas';
        $action = route('admin.grup.kelas.store', $grup->id);
        $tableHeading = json_encode(DataTable::heading(3));
        $itemProperties = json_encode(DataTable::props(3));
        $itemUrl = '/admin/grup/' . $grup->id . '/kelas/';
        $slug = '';

        $breadcrumbs = [
            [
                'name' => $grup->nama,
                'href' => route('admin.grup.show', $grup->id)
            ]
        ];

        $itemName = $grup->nama;
        $itemDescription = $grup->deskripsi;

        return view('admin.grup.show', compact(
            'breadcrumbs', 'title', 'fetchUrl', 'grup', 'item', 'judul', 'action', 'slug', 'tableHeading', 'itemProperties', 'itemUrl', 'itemName', 'itemDescription'
        ));
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
