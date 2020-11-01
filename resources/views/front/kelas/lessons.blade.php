@extends('front.kelas.base')

@section('content')
    <div class="page-header">
        <h2>Pelajaran</h2>
    </div>

    <div class="row row-deck">

        @foreach ($lessons as $lesson)

            <div class="col-md-4">
                <a class="card card-link" href="#">
                    <div class="card-header">
                        <h3 class="card-title">{{ $lesson->judul }}</h3>
                    </div>
                    <div class="card-body">
                        <p>{{ $lesson->deskripsi }}</p>
                    </div>
                </a>
            </div>
        
        @endforeach

    </div>
@endsection