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

        $question = Question::create($request['question']);

        $exam->questions()->syncWithoutDetaching([
            $question->id => ['urutan' => $this->service->getUrutan($exam)]
        ]);

        $question->answers()->createMany($request['answers']);

        return [
            'question' => $question,
            'answers' => $question->answers
        ];
    }

    public function update(Request $request)
    {
        
    }
}
