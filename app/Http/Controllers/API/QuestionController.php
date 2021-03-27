<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use App\Services\Admin\QuestionService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function __construct(QuestionService $questionService)
    {   
        $this->service = $questionService;
    }

    public function store(Request $request)
    {
        $exam = Exam::find($request['examId']);

        $soal = Question::create($request['question']);

        $exam->questions()->syncWithoutDetaching([
            $soal->id => ['urutan' => $this->service->getUrutan($exam)]
        ]);

        $soal->answers()->createMany($request['answers']);

        return [
            'question' => $soal,
            'answers' => $soal->answers
        ];
    }

    public function update(Question $soal, Request $request)
    {
        $soalKeys = ['kode', 'tipe', 'konten']; 
        $answerKeys = ['redaksi', 'benar', 'nilai'];

        foreach ($soalKeys as $key) {
            $soal->$key = $request['question'][$key];
        }

        $soal->save();
        
        for ($i=0; $i < count($request['answers']); $i++) { 
            if (array_key_exists('id', $request['answers'][$i])) {
                $answer = $soal->answers->filter( function ($answer) use ($request, $i) {
                    return $answer->id == $request['answers'][$i]['id'];
                });

                foreach ($answerKeys as $key) {
                    $answer->$key = $request['answers'][$i][$key];
                }
            } else {
                $soal->answers()->create($request['answers'][$i]);
            }
        }

        /* $i = 0;
        foreach ($soal->answers as $answer) {
            if (array_key_exists('id', $request['answers'][$i])) {
                foreach ($answerKeys as $key) {
                    $answer->$key = $request['answers'][$i][$key];
                }
                
                $answer->save();
            } else {
                $soal->answers()->create($request['answers'][$i]);
            }

            $i++;
        } */

        return [
            'question' => $soal,
            'answers' => $soal->answers
        ];
    }   
}
