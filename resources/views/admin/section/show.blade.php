@extends('admin.main')

@section('content')
<div id="app">

    <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.pelajaran.index') }}">Pelajaran</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="#">
            {{ $pelajaran->judul }}
        </a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">
            {{ $section->judul }}
        </a></li>
    </ol>

    <h2 class="h1 font-weight-bold">{{ $section->judul }}</h2>
    <p>
        {{ $section->deskripsi }}
    </p>

    <ul class="list-inline">
        <li class="list-inline-item"><small><a href="#">Edit</a></small></li>
        <li class="list-inline-item"><small><a href="#" class="text-danger">Hapus</a></small></li>
    </ul>

    <section-page
        title="{{ $section->judul }}"
        assign-exam-url="{{ $assignExamUrl }}"
        :assigned-exams-id="{{ json_encode($assignedExams->pluck('id')) }}"
        :assigned-exams="{{ json_encode($assignedExams) }}"
     ></section-page>
   
</div>
@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush

