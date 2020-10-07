<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\User;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('admin.general.index', [
            'item' => 'user',
            'judul' => 'Judul ujian',
            'slug' => 'Slug URL',
            'url' => $_SERVER['SERVER_NAME'] . '/kelas/{kelas}/ujian',
            'action' => route('admin.ujian.store'),
            'tableHeading' => json_encode([
                [
                    'name' => 'Nama',
                    'width' => '25%'
                ], 
                
                [
                    'name' => 'Username',
                    'width' => null
                ],

                [
                    'name' => 'Jenis Kelamin',
                    'width' => null
                ]
            ]),
            'itemProperties' => json_encode(['id', 'nama', 'username', 'gender'])
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $this->userService->store($request->validated());

        return redirect(route('admin.user.index'));
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

    public function edit(User $user)
    {
        return view('admin.user.edit', [
            'user' => $user
        ]);
    }


    public function update(UpdateUserRequest $request, User $user)
    {

        $this->userService->update($request->validated(), $user);

        return redirect(route('admin.user.index'));
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
