@extends('front.kelas.base')

@section('content')
<div class="page-header">
    <h2>Tugas dan Ujian</h2>
</div>

<div class="row">

    @foreach ($exams as $exam)

        <div class="col-md-4">
            <div class="card card-link" href="#">

                <div class="card-body">
                    <h3 class="card-title">{{ $exam->judul }}</h3>

                    <p>{!! $exam->deskripsi !!}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('kelas.exam.info', ['classroom' => $kelas->kode, 'exam' => $exam->slug]) }}" class="btn btn-primary">Buka</a>
                </div>
            </div>
        </div>
    
    @endforeach

</div>
@endsection