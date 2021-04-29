@extends('front.main')

@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            @include('front.ujian._top')

            @include('_lembar-jawaban')

        </div>
    </div>
@endsection