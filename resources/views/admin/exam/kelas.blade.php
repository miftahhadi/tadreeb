@extends('admin.exam.main')

@section('examContent')
    <div id="app">
        <exam-kelas
            :exam-id="{{ $ujian->id }}"
            :table-heading="{{ $tableHeading }}"
            :item-properties="{{ $itemProperties }}" 
        ></exam-kelas>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush