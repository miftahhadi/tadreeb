<?php

namespace App\Http\Controllers\Admin;

use App\DataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\QuestionService;
use App\Http\Requests\Admin\StoreQuestionRequest;
use App\Http\Requests\Admin\UpdateQuestionRequest;
use App\Models\Exam;
use App\Models\Question;

class QuestionController extends Controller
{
    protected $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function index()
    {
        $breadcrumbs = [];

        $heading = [
            [
                'name' => 'ID',
                'width' => '5%'
            ],
            [
                'name' => 'Kode',
                'width' => '10%'
            ], 
            
            [
                'name' => 'Konten',
                'width' => null
            ]
        ];

        $properties = ['id', 'kode', 'konten'];

        $title = 'Bank Soal';
        $fetchUrl = '/api/soal';
        $item = 'soal';
        $judul = 'Judul soal';
        $tableHeading = json_encode($heading);
        $itemProperties = json_encode($properties);
        $nameShownAs = 'judul';

        return view('admin.general.item-index', compact(
            'breadcrumbs','title', 'fetchUrl', 'item', 'judul',
            'tableHeading', 'itemProperties',
            'nameShownAs' 
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $breadcrumbs = [];

        $itemName = null;
        $itemDescription = null;

        $title = 'Soal Baru';

        $ujianId = null;

        if ($request['ujian']) {
            $ujian = Exam::find($request['ujian']);

            $breadcrumbs = [
                [
                    'name' => 'Ujian',
                    'href' => route('admin.ujian.index')
                ],
                [
                    'name' => $ujian->judul,
                    'href' => route('admin.ujian.show', $ujian->id)
                ]
            ];
            
            $itemName = $ujian->judul;

            $title = $title . ' - ' . $ujian->judul;
        
            $ujianId = $ujian->id;
        }

        $questionForm = $this->questionService->createQuestionForm($request);

        return view('admin.question.create', [
            'breadcrumbs' => $breadcrumbs,
            'itemName' => $itemName,
            'itemDescription' => $itemDescription,
            'title' => $title,
            'ujianId' => $ujianId,
            'choices' => $questionForm['choices'],
            'value' => $questionForm['value'] ?? '',
            'option' => $questionForm['option']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Exam $ujian)
    {
        dd($request->all());
        // $this->questionService->simpanSoal($request, $ujian);

        // return redirect(route('admin.ujian.show', $ujian->slug));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $soal, Request $request)
    {
        $breadcrumbs = [];

        $itemName = null;
        $itemDescription = null;

        $title = 'Edit Soal';

        $ujianId = null;

        if ($request['ujian']) {
            $ujian = Exam::find($request['ujian']);

            $breadcrumbs = [
                [
                    'name' => 'Ujian',
                    'href' => route('admin.ujian.index')
                ],
                [
                    'name' => $ujian->judul,
                    'href' => route('admin.ujian.show', $ujian->id)
                ]
            ];
            
            $itemName = $ujian->judul;

            $title = $title . ' - ' . $ujian->judul;
        
            $ujianId = $ujian->id;
        }

        return view('admin.question.edit',[
            'title' => $title,
            'ujianId' => $ujianId,
            'soal' => $soal,
            'itemName' => $itemName,
            'itemDescription' => $itemDescription,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Question  $soal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionRequest $request, Exam $ujian, Question $soal)
    {
        $this->questionService->update($request->validated(), $soal);

        return redirect(route('admin.ujian.show', $ujian->slug));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $soal)
    {
        $soal->delete();

        return redirect(route('admin.ujian.index')); // TODO: buat route ke bank soal
    }

    public function unassignFromExam(Exam $ujian, Question $soal)
    {
        $ujian->questions()->detach($soal->id);

        return redirect(route('admin.ujian.show', $ujian->slug));
    }
}
