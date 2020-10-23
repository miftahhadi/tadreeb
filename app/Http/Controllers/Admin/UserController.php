<?php

namespace App\Http\Controllers\Admin;

use App\CsvUserData;
use App\DataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\CsvImportRequest;
use App\User;
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
        return view('admin.general.index', [
            'fetchUrl' => '/api/user',
            'item' => 'user',
            'judul' => 'Judul ujian',
            'slug' => 'Slug URL',
            'url' => $_SERVER['SERVER_NAME'] . '/kelas/{kelas}/ujian',
            'action' => route('admin.ujian.store'),
            'tableHeading' => json_encode(DataTable::heading('user')),
            'itemProperties' => json_encode(DataTable::props('user'))
        ]);
    }

    public function list()
    {
        return response()->json(User::paginate(10));
    }

    public function search($search)
    {
        return response()->json(User::where('nama', 'like', '%' . $search . '%')
                                        ->orWhere('username', 'like', '%' .  $search . '%')
                                        ->orWhere('email', 'like', '%' . $search . '%')
                                        ->paginate(10)
                );
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function getCsv()
    {
        return view('admin.user.import-csv', [
            'userField' => $this->service->userField
        ]);
    }

    public function parseCsv(CsvImportRequest $request)
    {
        $validated = $request->validated()['csv_file'];

        $data = $this->service->parseCsv($validated);

        $dataToShow = array_slice(json_decode($data->csv_data), 1, 3);

        return view('admin.user.preview-csv', [
            'dataToShow' => json_encode($dataToShow),
            'csvDataFile' => $data,
            'fields' => json_encode($this->service->userField)
        ]);
    }

    public function processCsv(Request $request)
    {
        // dd($request);
        
        return json_encode($this->service->processCsv($request->id));
    }

    public function store(StoreUserRequest $request)
    {
        $this->service->store($request->validated());

        return redirect(route('admin.user.index'));
    }

    public function show($id)
    {
        //
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', [
            'user' => $user
        ]);
    }


    public function update(UpdateUserRequest $request, User $user)
    {

        $this->service->update($request->validated(), $user);

        return redirect(route('admin.user.index'));
    }

    public function destroy($id)
    {
        //
    }
}
