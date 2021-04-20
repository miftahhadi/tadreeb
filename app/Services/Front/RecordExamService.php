<?php

namespace App\Services\Front;

use App\Models\Classroom;
use App\Models\Exam;
use App\Models\Examable;
use App\Models\ExamableUser;
use Carbon\Carbon;

class RecordExamService
{
    public $exam;
    public $classroom;
    public $examable;
    public $examableuser;

    protected $tz;
    protected $durasi;
    protected $batasBuka;

    public function __construct(Examable $examable)
    {   
        $this->examable = $examable;
    }

    public function makeUserData()
    {
        // Rekam waktu_mulai user pakai UTC
        $waktuMulai = Carbon::now('UTC');

        // Rekam data pengerjaan user
        $answers = [];

        foreach ($this->examable->exam->questions()->get() as $question) {
            
            if ($question->tipe == 'Jawaban Ganda') {
                $answers[$question->id] = [
                    'answers' => [],
                    'score' => 0
                ];
            } else {
                $answers[$question->id] = [
                    'answers' => '',
                    'score' => 0
                ];
            }

        }

        $userId = auth()->user()->id;

        $examableuser = ExamableUser::create([
            'examable_id' => $this->examable->id,
            'user_id' => $userId,
            'attempt' => $this->examable->userLastAttempt($userId) + 1,
            'answers' => json_encode($answers),
            'waktu_mulai' => $waktuMulai
        ]);

        return $examableuser;

    }

    protected function questionsId()
    {
        return $this->exam->questions()
                            ->get()
                            ->pluck('id')
                            ->toArray();
    }

    public function getExamableUserId()
    {
        return $this->examableuser->id;    
    }
    
    public function getUserAnswers()
    {
        return $this->examableuser->answers;
    }
}