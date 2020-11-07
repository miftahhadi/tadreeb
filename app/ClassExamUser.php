<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassExamUser extends Pivot
{
    protected $table = 'classroomexam_user';
    public $incrementing = true;
}
