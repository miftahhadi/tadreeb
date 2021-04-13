<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $kelasUser = auth()->user()->classrooms->load(['group','exams']);
        $data = [];

        $examExist = 0;

        foreach ($kelasUser as $kelas) {
            $partial = [
                'kelas_nama' => $kelas->nama,
                'kelas_id' => $kelas->id,
                'kelas_kode' => $kelas->kode,
                'grup' => $kelas->group->nama
            ];

            $exams = $kelas->getActiveExamsByUser(auth()->user()->id, 5);

            if ($exams) {
                $examExist++;
            }

            $partial['ujian'] = $exams;
            array_push($data, $partial);
        }

        return view('front.dashboard-user', [
            'title' => 'Halaman Depan',
            'user' => auth()->user(),
            'data' => $data,
            'examExist' => $examExist,
        ]);
    }
}
