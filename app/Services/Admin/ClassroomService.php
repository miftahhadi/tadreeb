<?php 

namespace App\Services\Admin;

use App\Models\Classroom;
use App\Models\Group;
use App\DataTable;
use Illuminate\Support\Str;

class ClassroomService
{

    protected $kelas;

    protected $navMenu = ['Ikhtisar', 'Pelajaran', 'Ujian', 'Anggota', 'Pengaturan'];

    public $lessons = [];
    public $exams = [];
    public $users = [];

    public function store($data, Group $grup)
    {
        return $grup->classrooms()->create([
            'nama' => $data['judul'],
            'kode' => Str::random(10),
            'deskripsi' => $data['deskripsi']
        ]);
    }

    public function show(Classroom $kelas)
    {
        $this->kelas = $kelas;

        $this->lessons = $this->itemData('pelajaran');
        $this->lessons['assigned'] = $this->lessons();

        $this->exams = $this->itemData('ujian');
        $this->exams['assigned'] = $this->exams(); 

        $this->users = $this->itemData('user');
        $this->users['assigned'] = $this->users();

        return $this;
    }

    public function getNavMenu()
    {
        return $this->navMenu;
    }

    public function itemData($item)
    {
        $param = ($item == 'user') ? $item : 'default'; 

        $data =  [
            'heading' => DataTable::heading($param),
            'props' => DataTable::props($param),
            'fetchUrl' => '/api/kelas/' . $this->kelas->id . '/' . $item 
        ];

        return $data;
    }

    private function lessons()
    {
        return $this->kelas->lessons()
                            ->pluck('lesson_id')
                            ->all();
    }

    private function exams()
    {
        return $this->kelas->exams()
                            ->pluck('exam_id')
                            ->all();
    }

    private function users()
    {
        return $this->kelas->users()
                            ->pluck('user_id')
                            ->all();
    }

}