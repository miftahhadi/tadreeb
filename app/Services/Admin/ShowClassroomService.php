<?php 

namespace App\Services\Admin;

use App\Models\Classroom;
use App\DataTable;
use Illuminate\Http\Request;

class ShowClassroomService
{

    protected $kelas;
    public $navMenu = ['Pelajaran', 'Ujian', 'Anggota', 'Pengaturan'];
    public $itemData = [];

    public function show(Classroom $kelas, Request $request)
    {
        $this->kelas = $kelas;

        
        if ($request->page && $request->page != 'pengaturan') {
            $this->setItemData($$request->page);
        }
        
        return $this;
    }

    public function getItemName($page)
    {
        $itemNames = [
            'pelajaran' => 'lessons',
            'ujian' => 'exams',
            'anggota' => 'users'
        ];

        return $itemNames[$page];

    }

    public function setItemData($item)
    {
        $arg = ($item == 'anggota') ? 'user' : 'default'; 

        $itemName = $this->getItemName($item, 'plural');
        $itemId = $this->getItemName($item, 'plural') . '.id';

        $data =  [
            'item' => $item,
            'heading' => DataTable::heading($arg),
            'props' => DataTable::props($arg),
            'fetchUrl' => '/api/kelas/' . $this->kelas->id . '/' . $item,
            'assigned' => $this->kelas->$itemName()->pluck($itemId)->all()
        ];

        $this->itemData = $data;
    }


}