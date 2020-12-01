<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function assignExam(Section $section, Request $request)
    {
        $ujianId = $request->input('itemId');

        return $section->exams()->toggle($ujianId);

    }
}
