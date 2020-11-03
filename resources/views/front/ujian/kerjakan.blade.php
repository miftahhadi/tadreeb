@extends('front.main')

@section('content')
    <div class="row d-flex justify-content-center">

        <div>
            <ol class="breadcrumb breadcrumb-arrows mb-2" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kelas.home', $kelas->kode) }}">Kelas {{ $kelas->nama }}</a></li>
            </ol>
    
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <h2 class="h1">{{ $exam->judul }}</h2>   
                    </div>
                </div>
    
     
            </div>
        </div>
    </div>

    <div id="app">
        <exam-doing-page
            :exam-id="{{ $exam->id }}"
        ></exam-doing-page>
    </div>

@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush