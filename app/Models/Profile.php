<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['tanggal_lahir'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTanggalLahirStringAttribute()
    {
        return ($this->tanggal_lahir) ? $this->tanggal_lahir
                                                ->tz(settings('timezone'))
                                                ->locale('id')
                                                ->isoFormat('D MMM Y')
                                        : null; 
    }

    public function getTanggalLahirDateString()
    {
        return ($this->tanggal_lahir) ? $this->tanggal_lahir
                                            ->tz(settings('timezone'))
                                            ->toDateString()
                                        : null;
    }
}
