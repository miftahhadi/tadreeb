@extends('admin.main')

@section('content')
    @include('admin._item-header')

    <div id="app">
        <question-create
            :exam-id="{{ $ujian->id }}"
            :question-model="{{ $soal }}"
        >
        </question-create>
    </div>

@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush