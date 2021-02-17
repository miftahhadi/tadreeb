<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return response()
                ->json(User::select('id','name', 'username')
                ->addSelect([
                    'gender' => Profile::select('gender')
                                        ->whereColumn('user_id', 'users.id'),
                    'role' => Role::select('role')
                                    ->join('role_user', 'roles.id', '=', 'role_user.role_id')
                                    ->whereColumn('role_user.user_id', 'users.id')
                ])->paginate(25));
    }

    public function search($search)
    {
        return response()->json(
            User::where('name', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' .  $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->paginate(25)
        );
    }

    public function checkData(Request $request)
    {
        $type = $request->input('type');
        $data = $request->input('data');
        $id = $request->input('id');

        $user = User::where($type, $data)->first();

        return ($user && $user['id'] != $id) ? 1 : 0;
    }

    public function store(Request $request)
    {
        $data = $request->input('data');

        try {
            $user = User::create([
                'name' => $data['nama'],
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => Hash::make($data['password'])
            ]);
    
            $user->profile()->create([
                'gender' => $data['gender'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'whatsapp' => $data['whatsapp'],
                'telegram' => $data['telegram']
            ]);

            $user->roles()->sync([$data['peran']]);

            return 'user created';
        } catch (\Throwable $th) {
            return 'error: ' . $th;
        }
    }

    public function show(User $user)
    {
        return response($user->load('profile'));
    }

    public function destroy(User $user)
    {
        return $user->delete();
    }
}
