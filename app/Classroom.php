<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function lessons()
    {
        return $this->belongsToMany((Lesson::class));
    }
}
