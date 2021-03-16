<?php 

namespace App\Services\Admin;

use App\Models\Classroom;
use App\Models\Group;
use App\DataTable;
use Illuminate\Support\Str;

class ClassroomService
{

    protected $kelas;

    public $navMenu = ['Pelajaran', 'Ujian', 'Anggota', 'Pengaturan'];

    public $itemData = [];

    public function store($data, Group $grup)
    {
        return $grup->classrooms()->create([
            'nama' => $data['judul'],
            'kode' => Str::random(10),
            'deskripsi' => $data['deskripsi']
        ]);
    }

    public function show(Classroom $kelas, $page = null)
    {
        $this->kelas = $kelas;

        if ($page != null && $page != 'pengaturan') {
            $this->setItemData($page);
        }
        
        return $this;
    }

    public function getItemName($page, $mode = 'singular')
    {
        $itemNames = [
            'pelajaran' => 'lesson',
            'ujian' => 'exam',
            'anggota' => 'user'
        ];

        return ($mode == 'plural') ? $itemNames[$page] . 's' : $itemNames[$page];

    }

    public function setItemData($item)
    {
        $param = ($item == 'anggota') ? 'user' : 'default'; 

        $itemName = $this->getItemName($item, 'plural');
        $itemId = $this->getItemName($item, 'plural') . '.id';

        $data =  [
            'item' => $item,
            'heading' => DataTable::heading($param),
            'props' => DataTable::props($param),
            'fetchUrl' => '/api/kelas/' . $this->kelas->id . '/' . $item,
            'assigned' => $this->kelas->$itemName()->pluck($itemId)->all()
        ];

        $this->itemData = $data;
    }


}