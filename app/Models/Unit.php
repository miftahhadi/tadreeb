<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function exams()
    {
        return $this->morphedByMany(Exam::class, 'unitable');
    }

    public function contents()
    {
        return $this->hasMany(UnitContent::class);
    }
}
