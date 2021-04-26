@extends('admin.exam.main')

@section('examContent')
    <div id="app">
        <p>Kelas yang mengujikan ujian {{ $ujian->judul }}:</p>
        <exam-kelas
            :exam-id="{{ $ujian->id }}"
            :table-heading="{{ $data['tableHeading'] }}"
            :item-properties="{{ $data['itemProperties'] }}" 
        ></exam-kelas>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush