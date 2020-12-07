<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        // $classrooms = auth()->user()->classrooms->
        dd(auth()->user()->can('access admin'));
        return view('front.dashboard-user', [
            'title' => 'Halaman Depan'
        ]);
    }
}
