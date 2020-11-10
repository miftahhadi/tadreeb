<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionContent extends Model
{
    use HasFactory;

    protected $table = 'sectionables';

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
