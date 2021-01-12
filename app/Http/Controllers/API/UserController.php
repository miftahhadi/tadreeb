<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list()
    {
        return response()->json(User::paginate(25));
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
