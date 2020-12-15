@extends('admin.exam.main')

@section('examContent')
<div class="row mb-2">
    <div class="col-auto">

        @if ($data['mode'] == 'classroomList')
            <h2>Pilih Kelas</h2>
            <p>Kelas yang mengujikan ujian {{ $ujian->judul }}:</p>
        @elseif (array_key_exists('kelas', $data))
            <h2>Kelas: {{ $data['kelas']->nama }}</h2>

            @if ($data['mode'] == 'showAll')
                Daftar anggota kelas 
            @else 
                <p>Anggota kelas yang @if ($data['mode'] == 'showDone') <b>sudah</b> @else <b>belum</b> @endif mengerjakan.</p>               
            @endif
        @endif

    </div>    
</div>

@if ($data['mode'] != 'classroomList')
    <div class="btn-list">
        <a href="{{ route('admin.ujian.hasil', ['ujian' => $ujian->slug, 'kelas' => $data['kelas']->id]) }}"
            class="btn @if ($data['mode'] == 'showAll') bg-indigo-lt @endif"
        >Semua anggota kelas</a>

        <a href="{{ route('admin.ujian.hasil', ['ujian' => $ujian->slug, 'kelas' => $data['kelas']->id, 'done' => 'true']) }}"
            class="btn @if ($data['mode'] == 'showDone') bg-indigo-lt @endif"
        >Sudah mengerjakan</a>

        <a href="{{ route('admin.ujian.hasil', ['ujian' => $ujian->slug, 'kelas' => $data['kelas']->id, 'done' => 'false']) }}"
            class="btn @if ($data['mode'] == 'showNotDone') bg-indigo-lt @endif"
        >Belum mengerjakan</a>
    </div>
@endif

@include('admin.exam._result-table')

@endsection