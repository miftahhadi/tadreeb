<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function exams()
    {
        return $this->morphedByMany(Exam::class, 'sectionable');
    }

    public function contents()
    {
        return $this->hasMany(SectionContent::class);
    }
}
