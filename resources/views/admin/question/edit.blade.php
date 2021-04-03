@extends('admin.main')

@section('content')
    @include('admin._item-header')

    <div id="app">
        @if ($ujianId != null)
            <question-form
                :exam-id="{{ $ujianId }}"
                :question-model="{{ $soal }}"
            >
            </question-form>
        @else
            <question-form
                :question-model="{{ $soal }}"
            >
            </question-form>
        @endif

    </div>

@endsection

@push('js')
    <script type="text/javascript" src="/dist/js/app.js"></script>    
@endpush