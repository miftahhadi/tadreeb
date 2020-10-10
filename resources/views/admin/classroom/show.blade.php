@extends('admin.main')

@section('content')
    <div id="app">
        <h2 class="h1 font-weight-bold">{{ $kelas->nama }}</h2>
        
        <p>
            {{ $kelas->deskripsi }}
        </p>

        <ul class="list-inline">
            <li class="list-inline-item"><small><a href="#">Edit</a></small></li>
            <li class="list-inline-item"><small><a href="#" class="text-danger">Hapus</a></small></li>
        </ul>

        <div>
            <ul class="nav nav-tabs">
                <li class="nav-item"><a href="#pelajaran" class="nav-link active" data-toggle="tab">Pelajaran</a></li>
                <li class="nav-item"><a href="#ujian" class="nav-link" data-toggle="tab">Ujian</a></li>
                <li class="nav-item"><a href="#anggota" class="nav-link" data-toggle="tab">Anggota</a></li>
                <li class="nav-item"><a href="#pengaturan" class="nav-link" data-toggle="tab">Pengaturan Kelas</a></li>
            </ul>
            <div class="tab-content">
                @include('kelas._pelajaran')
        
                @include('kelas._ujian')
        
                @include('kelas._anggota')

                @include('kelas._setting')
            </div>
        </div>

    </div>
@endsection