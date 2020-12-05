<?php

namespace App\Http\Controllers\API;

use App\Models\Answer;
use App\Models\ClassExamUser;
use App\Models\Exam;
use App\Http\Controllers\Controller;
use App\Models\ClassroomExam;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function getExam(Exam $exam)
    {
        $exam->loadCount('questions');

        $questionIds = $exam->questions()->get()->pluck('id');

        $questions = $exam->questions()->with('answers')->get();

        foreach ($questions as $question) {
            $question['input'] = ($question['tipe'] == 'Jawaban Ganda') ? 'checkbox' : 'radio';
        }

        return json_encode([
                        'exam' => $exam, 
                        'questionIds' => $questionIds, 
                        'questions' => collect($questions)->keyBy('id')
                    ]);
    }

    public function getQuestion(Question $soal)
    {
        $answers = $soal->answers()->get();

        return json_encode(['soal' => $soal, 'answers' => $answers]);
    }

    public function getUserAnswers($id)
    {
        $classExamUser = ClassExamUser::find($id);
        
        return json_decode($classExamUser->answers, true);
    }

    public function updateUserAnswers(Request $request)
    {
        $classExamUser = ClassExamUser::find($request['classexamuserId']);
        $userAnswers = $request['answerIds'];
        $questionId = $request['questionId'];

         // Ambil daftar jawaban
        $answers = json_decode($classExamUser->answers, true);

        // Cek nilai jawaban
        $scores = 0;

        if (is_array($userAnswers)) {
            
            foreach ($userAnswers as $id) {
                $scores += $this->assignScore($id);
            }
            
        } else {
            $scores += $this->assignScore($userAnswers);
        }

        // Update jawaban untuk questionId
        $answers[$questionId]['answers'] =  $userAnswers;
        $answers[$questionId]['score'] =  $scores;

        $classExamUser->answers = json_encode($answers);

        return $classExamUser->save();
    }

    protected function assignScore($id)
    {
        $answer = Answer::find($id);

        return $answer->nilai;
    }

    public function submitExam(Request $request)
    {
        $classExamUser = ClassExamUser::find($request['classexamuserId']);

        $classExamUser->waktu_selesai = now('UTC');

        return $classExamUser->save();
    }

}
