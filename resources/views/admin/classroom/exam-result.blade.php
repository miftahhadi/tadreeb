@extends('admin.main')

@section('content')
    <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.grup.show', $grup->id) }}">{{ $grup->nama }}</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">
            {{ $kelas->nama }}
        </a></li>
    </ol>

    <div class="mb-4">
        <h2 class="h1 font-weight-bold">{{ $kelas->nama }}</h2>

        <p>
            {{ $kelas->deskripsi }}
        </p>

        <ul class="list-inline">
            <li class="list-inline-item"><small><a href="{{ route('kelas.home', $kelas->kode) }}">Buka Halaman Kelas</a></small></li>
            <li class="list-inline-item"><small><a href="#">Edit</a></small></li>
            <li class="list-inline-item"><small><a href="#" class="text-danger">Hapus</a></small></li>
        </ul>
    </div>
@endsection