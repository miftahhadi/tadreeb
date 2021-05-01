<?php

namespace App\Http\Controllers\Admin;

use App\Models\CsvUserData;
use App\DataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\CsvImportRequest;
use App\Models\User;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    public function index()
    {
        $breadcrumbs = [];

        return view('admin.general.item-index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Daftar User',
            'fetchUrl' => '/api/user',
            'item' => 'user',
            'tableHeading' => json_encode(DataTable::heading('user')),
            'itemProperties' => json_encode(DataTable::props('user')),
            'nameShownAs' => 'name'
        ]);
    }

    public function create()
    {
        return view('admin.user.create', [
            'title' => 'Tambah User Baru'
        ]);
    }

    public function getCsv()
    {
        $breadcrumbs = [
            [
                'name' => 'User',
                'href' => route('admin.user.index')
            ]
        ];

        $itemName = 'Impor User dari File CSV';

        return view('admin.user.import-csv', [
            'title' => 'Impor User dari CSV',
            'breadcrumbs' => $breadcrumbs,
            'itemName' => $itemName,
            'itemDescription' => null,
            'userField' => $this->service->userField
        ]);
    }

    public function parseCsv(CsvImportRequest $request)
    {
        $validated = $request->validated()['csv_file'];

        $data = $this->service->parseCsv($validated);

        return redirect(route('admin.user.previewCsv', ['csv' => $data->id]));
    }

    public function previewCsvData(Request $request)
    {
        $breadcrumbs = [
            [
                'name' => 'User',
                'href' => route('admin.user.index')
            ]
        ];

        $itemName = 'Pratinjau Data CSV';

        $data = CsvUserData::find($request['csv']);
        $dataToShow = array_slice(json_decode($data->csv_data), 1, 3);

        return view('admin.user.preview-csv', [
            'title' => 'Pratinjau Data CSV',
            'breadcrumbs' => $breadcrumbs,
            'itemName' => $itemName,
            'itemDescription' => null,
            'dataToShow' => json_encode($dataToShow),
            'csvDataFile' => $data,
            'fields' => json_encode($this->service->userField)
        ]);
    }

    public function processCsv(Request $request)
    {      
        return json_encode($this->service->processCsv($request->id));
    }

    public function show(User $user)
    {
        $breadcrumbs = [
            [
                'name' => 'User',
                'href' => route('admin.user.index')
            ]
        ];

        $itemName = 'Profil User';
        $itemDescription = null;

        return view('admin.user.show', [
            'title' => 'Profil ' . $user->name,
            'breadcrumbs' => $breadcrumbs,
            'itemName' => $itemName,
            'itemDescription' => $itemDescription,
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        $breadcrumbs = [
            [
                'name' => 'User',
                'href' => route('admin.user.index')
            ]
        ];

        $itemName = 'Edit User';
        $itemDescription = null;

        return view('admin.user.edit', [
            'title' => 'Edit User',
            'breadcrumbs' => $breadcrumbs,
            'itemName' => $itemName,
            'itemDescription' => $itemDescription,
            'user' => $user
        ]);
    }


    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        $user->update($data['akun']);
        $user->profile->update($data['profil']);
        $user->assignRole($data['role']);

        return redirect(route('admin.user.index'))->with('status', 'Profil User berhasil diperbarui');
    }

    public function destroy($id)
    {
        //
    }
}
