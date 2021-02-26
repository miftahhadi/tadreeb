<?php

namespace App\Http\Controllers\API;

use App\Models\Classroom;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Profile;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClassroomController extends Controller
{
    public function search($search)
    {
        return response()->json(
            Classroom::where('nama', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' .  $search . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(25)
            );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $grup = Group::find($request->input('parentId'));
        $data = $request->input('data');

        if ($grup) {
            $classroom = $grup->classrooms()->create([
                'nama' => $data['judul'],
                'kode' => Str::random(10),
                'deskripsi' => $data['deskripsi']
            ]);

            return $classroom;
        } else {
            return 'Error';
        }
        
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
        $kelas = Classroom::find($id);

        $kelas->delete();

        return;
    }

    public function lesson(Classroom $kelas)
    {
        return response()
                ->json(
                    $kelas
                        ->lessons()
                        ->orderByPivot('id', 'desc')
                        ->paginate(20)
                );
    }

    public function exam(Classroom $kelas)
    {
        return response()
                ->json(
                    $kelas
                    ->exams()
                    ->orderByPivot('id', 'desc')
                    ->paginate(20)
                );
    }

    public function user(Classroom $kelas)
    {
        return response()
                ->json(
                    $kelas->users()
                            ->addSelect([
                                'gender' => Profile::select('gender')
                                                    ->whereColumn('user_id', 'users.id'),
                                'role' => Role::select('role')
                                                ->join('role_user', 'roles.id', '=', 'role_user.role_id')
                                                ->whereColumn('role_user.user_id', 'users.id')
                            ])
                            ->paginate(20)
                    );
    }

    public function assignItem(Classroom $kelas, Request $request)
    {
        $item = $request['itemType'];
        $itemId = $request['itemId'];

        return $kelas->$item()->syncWithoutDetaching($itemId);
    }

    public function unassignItem(Classroom $kelas, Request $request)
    {
        $item = $request['itemType'];
        $itemId = $request['itemId'];

        return $kelas->$item()->detach($itemId);

    }

}
