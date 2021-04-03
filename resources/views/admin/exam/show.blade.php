@extends('admin.exam.main')

@section('examContent')
    <div id="app">
        <exam-question
            :exam-id="{{ $ujian->id }}"
            :questions-array="{{ $questions }}"
        ></exam-question>
    </div>
@endsection    

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush
