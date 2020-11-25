@extends('front.main')

@section('content')
    <div class="row d-flex justify-content-center">

        <div class="col-md-8">

            @include('front.ujian._top')

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bolder">Informasi Ujian</h2>
                </div>

                <div class="card-body">

                    <dl class="row">
                        <dt class="col-5">Jumlah soal:</dt>
                        <dd class="col-7">{{ $service->questionsCount() }}</dd>
                        <dt class="col-5">Durasi:</dt>
                        <dd class="col-7">{{ $service->durasi() }}</dd>
                        <dt class="col-5">Batas akses:</dt>
                        <dd class="col-7">{{ $service->batasBuka()  }}</dd>
                      </dl>

                </div>

            </div>

            <div class="alert alert-warning pb-0" role="alert">
                <ol>
                    <li>Awali segala hal baik dengan basmalah dan niat yang benar</li>
                    <li>Jelilah ketika membaca soal</li>
                </ol>
            </div>

            <div class="text-center">
                <a href="#" class="btn btn-white">Kembali</a>

                @if ($service->hasDone())
                    <a href="#" 
                        class="btn btn-primary">
                        Lihat Hasil
                    </a>                    
                @endif

                <a href="{{ route('kelas.exam.kerjakan', [ 
                                    'classroom' => $service->classroom->kode, 
                                    'exam' => $service->exam->slug 
                                ]) }}" 
                    class="btn btn-success">
                    Mulai Kerjakan
                </a>
            </div>
        </div>
    </div>
@endsection