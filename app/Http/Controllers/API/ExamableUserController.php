<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ExamableUser;
use Illuminate\Http\Request;

class ExamableUserController extends Controller
{
    public function destroy(ExamableUser $examableUser)
    {
        return $examableUser->delete();
    }
}
