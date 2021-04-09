<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $kelasUser = $user->classrooms->load(['group','exams']);
        $data = [];

        $examExist = 0;

        foreach ($kelasUser as $kelas) {
            $partial = [
                'kelas_nama' => $kelas->nama,
                'kelas_id' => $kelas->id,
                'kelas_kode' => $kelas->kode,
                'grup' => $kelas->group->nama
            ];

            $now = Carbon::now();
            
            $exams = $kelas->exams()
                            ->where('examables.tampil', 1)
                            ->orderBy('examables.id', 'desc')
                            ->take(5)
                            ->get()
                            ->filter(function($exam) use ($now) {
                                $hidden = ($exam->pivot->tampil == 1) ? 0 : 1;

                                if ($exam->pivot->tampil_otomatis) {
                                    $hidden = ($now->greaterThanOrEqualTo($exam->pivot->tampil_otomatis)) ? 0 : 1;
                                }

                                return ($hidden == 0);
                            })
                            ->map(function($exam) use ($now) {
                                $toShow = [
                                    'id' => $exam->id,
                                    'judul' => $exam->judul,
                                    'slug' => $exam->slug
                                ];

                                $bukaAkses = ($exam->pivot->buka == 1) ? 1 : 0;

                                if ($exam->pivot->buka_otomatis) {
                                    $bukaAkses = ($now->greaterThanOrEqualTo($exam->pivot->buka_otomatis)) ? 1 : 0;
                                }

                                $toShow['buka'] = $bukaAkses;

                                return $toShow;
                            })
                            ->toArray();

            if ($exams) {
                $examExist++;
            }

            $partial['ujian'] = $exams;
            array_push($data, $partial);
        }


        return view('front.dashboard-user', [
            'title' => 'Halaman Depan',
            'user' => $user,
            'data' => $data,
            'examExist' => $examExist,
        ]);
    }
}
