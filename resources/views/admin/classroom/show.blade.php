@extends('admin.main')

@section('content')
    <div id="app">

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
                <li class="list-inline-item"><small><a href="#">Edit</a></small></li>
                <li class="list-inline-item"><small><a href="#" class="text-danger">Hapus</a></small></li>
            </ul>
        </div>

        <kelas-index
            kelas="{{ $kelas->nama }}"
            :kelas-id="{{ $kelas->id }}"
            :lesson-data="{{ json_encode($service->lessons) }}"
            :exam-data="{{ json_encode($service->exams) }}"
            :user-data="{{ json_encode($service->users) }}"
        ></kelas-index>

        
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush