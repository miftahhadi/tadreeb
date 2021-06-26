<?php

namespace App\Http\Controllers\API;

use App\Models\Answer;
use App\Models\ClassExamUser;
use App\Models\Exam;
use App\Http\Controllers\Controller;
use App\Models\ExamableUser;
use App\Models\Question;
use App\Services\Admin\QuestionService;
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
                                        ->orderBy('created_at', 'desc')
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

    public function getExam(Exam $ujian)
    {
        $ujian->loadCount('questions');

        $questionIds = $ujian->questions()->get()->pluck('id');

        $questions = $ujian->questions()->with('answers')->get();

        foreach ($questions as $question) {
            $question['input'] = ($question['tipe'] == 'Jawaban Ganda') ? 'checkbox' : 'radio';
        }

        return json_encode([
                        'exam' => $ujian, 
                        'questionIds' => $questionIds, 
                        'questions' => collect($questions)->keyBy('id')
                    ]);
    }

    public function getQuestion(Question $soal)
    {
        $answers = $soal->answers()->get();

        return json_encode(['soal' => $soal, 'answers' => $answers]);
    }

    public function updateUserAnswers(Request $request)
    {
        $examableUser = ExamableUser::find($request->examableUserId);
        $userAnswers = $request->answerIds;
        $questionId = $request->questionId;

        // Ambil daftar jawaban
        $answers = json_decode($examableUser->answers, true);

        // Cek nilai jawaban
        $scores = $examableUser->assignScore($userAnswers);

        // Update jawaban untuk questionId
        $answers[$questionId]['answers'] =  $userAnswers;
        $answers[$questionId]['score'] =  $scores;

        $examableUser->answers = json_encode($answers);

        return $examableUser->save();
    }


    public function submitExam(Request $request)
    {
        $examableUser = ExamableUser::find($request->examableUserId);

        // Ambil daftar jawaban
        $answers = json_decode($examableUser->answers, true);

        foreach ($request->userAnswers as $questionId => $answerIds) {
            $score = $examableUser->assignScore($answerIds);

            $answers[$questionId]['answers'] = $answerIds;
            $answers[$questionId]['score'] = $score;
        }

        $examableUser->waktu_selesai = now('UTC');
        $examableUser->answers = $answers;

        return $examableUser->save();
    }

    public function getClassrooms(Exam $ujian, Request $request)
    {
        return response()->json($ujian->classrooms()->paginate(20));
    }

    public function assignQuestion(Exam $ujian, Request $request)
    {
        $questionService = new QuestionService();
        $soal = Question::find($request['itemId']);
        $urutan = $questionService->getUrutan($ujian);

        $ujian->questions()->syncWithoutDetaching([
            $soal->id => ['urutan' => $urutan]
        ]);

        $soal->urutan = $urutan;

        return $soal;
    }

    public function unassignQuestion(Request $request)
    {
        $ujian = Exam::find($request['examId'])->load('questions');

        if ($ujian) {
            $soal = $ujian->questions()->find($request['soalId']);

            // Semua soal yang urutannya lebih besar dari soal ini, kurangi urutannya

            foreach ($ujian->questions as $question) {
                if ($question->pivot->urutan > $soal->pivot->urutan) {
                    $urutan = $question->pivot->urutan -= 1;
                    $ujian->questions()->updateExistingPivot($question, ['urutan' => $urutan]);
                }
            }

            // Hapus dari daftar soal
            $ujian->questions()->detach($soal->id);

            return;
        }
    }
}
