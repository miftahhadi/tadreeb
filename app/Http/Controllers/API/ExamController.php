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
    public function index() 
    {
        return response()->json(Exam::orderBy('created_at', 'desc')->paginate(15));
    }

    public function search($search)
    {
        return response()->json(Exam::where('judul', 'like', '%' . $search . '%')
                                        ->orWhere('deskripsi', 'like', '%' .  $search . '%')
                                        ->orderBy('id', 'desc')
                                        ->paginate(10)
                                );
    }

    public function getSlug(Request $request)
    {
        $slug = $request['slug'];

        $exam = Exam::where('slug', $slug)->first();

        return ($exam) ? true : false;
    }

    public function store(Request $request)
    {
        $data = $request->input('data');

        $exam = Exam::create([
            'user_id' => $request->input('userId'),
            'judul' => $data['judul'],
            'slug' => $data['slug'],
            'deskripsi' => $data['deskripsi']
        ]);

        return response($exam);
    }

    public function destroy(Exam $ujian)
    {
        $ujian->questions()->detach();

        return $ujian->delete();
    }

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
