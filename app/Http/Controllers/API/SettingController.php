<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ClassroomExam;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function getExamSetting($examId, Request $request)
    {
        $classexam = ClassroomExam::where([
                        ['classroom_id', $request->input('kelas')],
                        ['exam_id', $examId]
                    ])->first();

        if (!$classexam) {
            return 0;
        } 

        $setting = [
            'tampil' => $classexam->tampil,
            'bukaAkses'=>  $classexam->buka,
            'bukaHasil' => $classexam->buka_hasil,
            'durasi' => $classexam->durasi,
            'attempt' => $classexam->attempt,
        ];

        $setting['autoTampil'] = $this->setWaktu($classexam, 'tampil_otomatis');
        $setting['autoBukaAkses'] = $this->setWaktu($classexam, 'buka_otomatis');
        $setting['batasBuka'] = $this->setWaktu($classexam, 'batas_buka');

        return $setting;

    }

    public function getLessonSetting($lessonId, Request $request)
    {

    }

    public function setWaktu($classexam, $classexamProp)
    {
        if ($classexam->$classexamProp instanceof Carbon) {
            $dt = $classexam->$classexamProp->tz(settings('timezone'));

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
        $classexam = ClassroomExam::where([
                        ['classroom_id', $request['kelasId']],
                        ['exam_id', $request['examId']]
                    ])->first();

        $setting = $request['setting'];

        $classexam->tampil = $setting['tampil'];
        $classexam->buka = $setting['bukaAkses'];
        $classexam->buka_hasil = $setting['bukaHasil'];
        $classexam->durasi = $setting['durasi'];
        $classexam->attempt = $setting['attempt'];

        $classexam->tampil_otomatis = $this->timeSetting($setting['autoTampil']);
        $classexam->buka_otomatis = $this->timeSetting($setting['autoBukaAkses']);
        $classexam->batas_buka = $this->timeSetting($setting['batasBuka']);

        return $classexam->save();
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
