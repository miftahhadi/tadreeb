<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ExamableUser extends Pivot
{
    use HasFactory;

    public function examable()
    {
        return $this->belongsTo(Examable::class);
    }

}
