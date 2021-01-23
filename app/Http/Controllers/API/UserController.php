<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            User::where('nama', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' .  $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->paginate(25)
        );
    }

    public function destroy(User $user)
    {
        return $user->delete();
    }
}
