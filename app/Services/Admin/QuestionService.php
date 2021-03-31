<?php

namespace App\Services\Admin;

use App\Models\Exam;
use App\Models\Question;

class QuestionService
{
    public function createQuestionForm($request)
    {
        $choices = $request['choices'] ?? 0;
        
        if ($request['type'] == 'benarsalah' || $request['type'] == 'benarsalahArabic') {
            $choices = 2;
        }

        $value = [];

        if ($request['type'] == 'benarsalah') {
            $value = [
                'benar' => 'Benar', 
                'salah' => 'Salah'
            ];
        }

        if ($request['type'] == 'benarsalahArabic') {
            $value = [
                'benar' => 'صحيح',
                'salah' => 'خطأ'
            ];
        }

        $option = '';
        
        if ($request['type'] == 'multiple') {
            $option = 'checkbox';
        } else {
            $option = 'radio';
        }

        return [
            'choices' => $choices,
            'value' => $value,
            'option' => $option
        ];
    }

    public function simpanSoal($data, Exam $exam)
    {
        $soal = new Question($data->soal);

        // Save the question
        $exam->questions()->save($soal, ['urutan' => $this->getUrutan($exam)]);

        
        // Create an answers array
        $answers = array();
        $jawabanBenar = array();

        foreach ($data->jawaban as $answer) {
            
            $answer['nilai'] = $answer['nilai'] ?? 0;

            // Masukkan ke array answers
            $answers[] = $answer;

            if (array_key_exists('benar',$answer) && $answer['benar'] == 1) {
                $jawabanBenar[] = 1;
            }

        }

        // Save the answers and assign them to the question
        $soal->answers()->createMany($answers);

        // Kalau tipe multiple tapi jawaban benar cuma satu, update tipe soal
        if ($soal->tipe == 2 && count($jawabanBenar) <= 1) {
            $soal->tipe = 1;
            $soal->save();
        }
    }

    public function getUrutan(Exam $exam)
    {
        // Cek urutan
        $max = $exam->questions()->max('urutan');
        
        return (is_null($max)) ? 1 : $max + 1;
    }

    public function cekJawaban($answersData)
    {
        

    }

    public function option($soal)
    {

        if ($soal->tipe == 'Jawaban Ganda') {
            return 'checkbox';
        } elseif ($soal->tipe == 'Pilihan Ganda') {
            return 'radio';
        }

    }

    public function update($data, Question $soal)
    {

    }

    public function updateSoal($data, Question $soal)
    {
        $soal->konten = $data['soal']['konten'];

        return $soal->save();
    }

}