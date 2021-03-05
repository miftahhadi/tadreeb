<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $examSettingField = [
        'tampil', 
        'buka', 
        'buka_hasil', 
        'tampil_otomatis', 
        'buka_otomatis', 
        'batas_buka', 
        'durasi', 
        'attempt'
    ];

    private $datetimeField = ['tampil_otomatis', 'buka_otomatis', 'batas_buka'];

    public function getExamSetting(Exam $exam, Request $request)
    {
        $examable = $exam->classrooms()->find($request['kelas'])->pivot;

        if (!$examable) {
            return 0;
        } 

        $setting = [
            'tampil' => $examable->tampil,
            'bukaAkses'=>  $examable->buka,
            'bukaHasil' => $examable->buka_hasil,
            'durasi' => $examable->durasi,
            'attempt' => $examable->attempt,
        ];

        $setting['autoTampil'] = $this->setWaktu($examable, 'tampil_otomatis');
        $setting['autoBukaAkses'] = $this->setWaktu($examable, 'buka_otomatis');
        $setting['batasBuka'] = $this->setWaktu($examable, 'batas_buka');

        return $setting;
    }

    public function getLessonSetting($lessonId, Request $request)
    {

    }

    public function setWaktu($model, $modelProp)
    {
        if ($model->$modelProp instanceof Carbon) {
            $dt = $model->$modelProp->tz(settings('timezone'));

            return [
                'tanggal' => $dt->format('Y-m-d'),
                'waktu' => $dt->format('H:i')
            ];
        } else {
            return [
                'tanggal' => null,
                'waktu' => '00:00'
            ];
        }
    }

    public function saveExamSetting(Request $request)
    {
        $exam = Exam::find($request['examId']);
        $examable = $exam->classrooms()->find($request['kelasId'])->pivot;

        $setting = $request['setting'];

        foreach ($this->examSettingField as $field) {
            $examable->$field = $setting[$field];
        }

        return $examable->save();
    }

    protected function timeSetting($setting) 
    {   
        if (!is_null($setting['tanggal'])) {
            $datetime = $setting['tanggal'] . ' ' . $setting['waktu'];

            return Carbon::createFromFormat('Y-m-d H:i', $datetime, 'utc');
        } else {
            return null;
        }
    }
}
