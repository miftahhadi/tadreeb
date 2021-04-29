<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ExamableUser extends Pivot
{
    use HasFactory;

    protected $appends = ['durasi'];
    public $incrementing = true;
    protected $dates = [
        'waktu_mulai',
        'waktu_selesai'      
    ];

    public function examable()
    {
        return $this->belongsTo(Examable::class);
    }

    public function assignScore($userAnswers)
    {
        $scores = 0;

        if (is_array($userAnswers)) {
            foreach ($userAnswers as $id) {
                $scores += (Answer::find($id))->nilai;
            }            
        } else {
            $scores += (Answer::find($userAnswers))->nilai;
        }

        $this->save();

        return $scores;
    }

    public function getWaktuMulaiString()
    {
        return $this->waktu_mulai
                        ->tz(settings('timezone'))
                        ->locale('id')
                        ->isoFormat('D MMM Y, HH:mm') 

                . ' ' . settings('tzName');
    }

    public function getWaktuSelesaiString()
    {
        $waktuSelesai = $this->waktu_selesai ?? $this->updated_at;

        return $waktuSelesai
                        ->tz(settings('timezone'))
                        ->locale('id')
                        ->isoFormat('D MMM Y, HH:mm') 

                . ' ' . settings('tzName');
    }

    public function getScoreAttribute()
    {
        $answers = collect(json_decode($this->answers, true));

        $score = $answers->map(function ($answer) {
            return $answer['score'];
        })->all();

        return array_sum($score);
    }

    public function getDurasiAttribute()
    {
        if ($this->waktu_selesai) {
            $durasiMs = $this->waktu_mulai->diffInMilliseconds($this->waktu_selesai);

            $minutes = floor(($durasiMs % (1000 * 60 * 60)) / (1000 * 60));
            $seconds = floor(($durasiMs % (1000 * 60)) / 1000);

            return ($minutes != 0) ? $minutes . ' menit ' . $seconds . ' detik'
                                    : $seconds . ' detik';
        }
    }
}
