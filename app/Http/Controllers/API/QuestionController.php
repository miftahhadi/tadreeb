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

    public function index() 
    {
        return response()->json(Question::orderBy('created_at', 'desc')->paginate(15));
    }

    public function search($search)
    {
        return response()->json(Question::where('konten', 'like', '%' . $search . '%')
                                        ->orWhere('kode', 'like', '%' .  $search . '%')
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(10)
                                );
    }

    public function store(Request $request)
    {
        $soal = Question::create($request['question']);
        $soal->answers()->createMany($request['answers']);

        if ($request['examId']) {
            $exam = Exam::find($request['examId']);
            $exam->questions()->syncWithoutDetaching([
                $soal->id => ['urutan' => $this->service->getUrutan($exam)]
            ]);    
        }

        return [
            'question' => $soal,
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

        if ($request['question']['tipe'] == 'Benar/Salah') {
            $soal->answers()->delete();
        }
        
        for ($i=0; $i < count($request['answers']); $i++) { 
            if (array_key_exists('id', $request['answers'][$i])) {
                $answer = $soal->answers()->find($request['answers'][$i]['id']);

                if (!$answer) {
                    continue;
                }

                foreach ($answerKeys as $key) {
                    $answer->$key = $request['answers'][$i][$key];
                }

                $answer->save();
            } else {
                $soal->answers()->create($request['answers'][$i]);
            }
        }

        $soal->refresh();

        return [
            'question' => $soal,
            'answers' => $soal->answers,
        ];
    }

    public function deleteAnswer(Question $soal, $jawaban)
    {
        return $soal->answers()->where('id', $jawaban)->delete();
    }
}
