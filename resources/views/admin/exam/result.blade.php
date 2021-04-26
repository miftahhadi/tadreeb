@extends('admin.exam.main')

@section('examContent')
    <div class="row mb-2">
        <div class="col-auto">

            @if ($data['mode'] == 'classroomList')
                <h2>Pilih Kelas</h2>
                <p>Kelas yang mengujikan ujian {{ $ujian->judul }}:</p>
            @elseif (array_key_exists('kelas', $data))
                <h2>Kelas: {{ $data['kelas']->nama }}</h2>
                <div class="text-muted mb-4">
                    <div>
                        Kode kelas: {{ $data['kelas']->kode }}
                    </div>
                    <div>
                        Grup: {{ $data['kelas']->group->nama }}
                    </div>
                </div>
                
                @if ($data['mode'] == 'showAll')
                    Daftar anggota kelas 
                @else 
                    <p>Anggota kelas yang @if ($data['mode'] == 'showDone') <b>sudah</b> @else <b>belum</b> @endif mengerjakan.</p>               
                @endif
            @endif

        </div>    
    </div>

    <div class="btn-list">
        <a href="{{ route('admin.ujian.kelas', ['ujian' => $ujian->id, 'kelasId' => $data['kelas']->id, 'show' => 'all']) }}"
            class="btn @if ($data['mode'] == 'showAll') bg-indigo-lt @endif"
        >Semua anggota kelas</a>

        <a href="{{ route('admin.ujian.kelas', ['ujian' => $ujian->id, 'kelasId' => $data['kelas']->id, 'show' => 'done']) }}"
            class="btn @if ($data['mode'] == 'showDone') bg-indigo-lt @endif"
        >Sudah mengerjakan</a>

        <a href="{{ route('admin.ujian.kelas', ['ujian' => $ujian->id, 'kelasId' => $data['kelas']->id, 'show' => 'unfinished']) }}"
            class="btn @if ($data['mode'] == 'showNotDone') bg-indigo-lt @endif"
        >Belum mengerjakan</a>
    </div>

    @include('admin.exam._result-table')

@endsection