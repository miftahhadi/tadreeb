<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
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

    public function destroy(Group $grup)
    {
        // Detach all classrooms
        
    }
}
