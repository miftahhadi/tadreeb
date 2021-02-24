@extends('admin.main')

@section('content')
    <div id="app">

        @include('admin._item-header')

        <kelas-index
            :kelas="{{ $kelas }}"
            :lesson-data="{{ json_encode($service->lessons) }}"
            :exam-data="{{ json_encode($service->exams) }}"
            :user-data="{{ json_encode($service->users) }}"
            tz-name="{{ settings('tzName') }}"
        ></kelas-index>

        
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush