<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        return response()->json(Group::orderBy('created_at', 'desc')->paginate(10));
    }

    public function search($search)
    {
        return response()->json(
            Group::where('judul', 'like', '%' . $search . '%')
                ->orWhere('deskripsi', 'like', '%' .  $search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10)
            );
    }
    public function store(Request $request)
    {
        $data = $request->input('data');

        $grup = Group::create([
            'nama' => $data['judul'],
            'deskripsi' => $data['deskripsi']
        ]);

        return response($grup);
    }

    public function destroy(Group $grup)
    {
        return $grup->delete();   
    }
}
