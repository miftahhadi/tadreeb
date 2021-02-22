<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassroomExam;
use App\Models\Exam;
use App\Models\Examable;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function getExamSetting(Exam $exam, Request $request)
    {
        $examable = $exam->classrooms()->find($request->input('kelas')->pivot);

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

        $examable->tampil = $setting['tampil'];
        $examable->buka = $setting['bukaAkses'];
        $examable->buka_hasil = $setting['bukaHasil'];
        $examable->durasi = $setting['durasi'];
        $examable->attempt = $setting['attempt'];

        $examable->tampil_otomatis = $this->timeSetting($setting['autoTampil']);
        $examable->buka_otomatis = $this->timeSetting($setting['autoBukaAkses']);
        $examable->batas_buka = $this->timeSetting($setting['batasBuka']);

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
