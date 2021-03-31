@extends('admin.exam.main')

@section('examContent')
    <div id="app">
        <exam-question
            :exam-id="{{ $ujian->id }}"
            :questions-array="{{ $questions }}"
        ></exam-question>
    </div>
@endsection    

@section('newQuestion')
    <!-- Tambah Soal -->
    @include('admin.exam._new-question-modal')

    <script>
        function showChoices(that) {
            if (that.value == "multiple" || that.value == "single") {
            document.getElementById("choices").disabled = false;
            } else {
            document.getElementById("choices").disabled = true;
            }
        }
    </script>
@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush
