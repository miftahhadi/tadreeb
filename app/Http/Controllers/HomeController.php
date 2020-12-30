<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function entry()
    {
        if (!auth()->check()) {
            return redirect(route('login'));
        }

        // if (auth()->user()->can('access admin')) {
        //     return redirect(route('admin.dashboard'));
        // } else {
        //     return redirect(route('dashboard'));
        // }
    }

    
}
