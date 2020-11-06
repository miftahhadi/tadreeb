@extends('front.main')

@section('content')
    <div class="row d-flex justify-content-center">

        <div class="col-md-8">

            <ol class="breadcrumb breadcrumb-arrows mb-2" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('kelas.home', $service->classroom->kode) }}">Kelas {{ $service->classroom->nama }}</a>
                </li>
            </ol>

            <div class="card card-sm bg-blue text-white rounded-lg">
                <div class="card-body pt-6">
                    <h2 class="h1 font-weight-bold">{{ $service->exam->judul }}</h2>
                </div>
            </div>

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
                        <dd class="col-7">{{ $service->batasBuka() . ' ' . settings('tzName') }}</dd>
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

                <a href="#" 
                    class="btn btn-primary">
                    Lihat Hasil
                </a>

                <a href="{{ route('kelas.exam.kerjakan', [ 'classroom' => $service->classroom->kode, 'exam' => $service->exam->slug ]) }}" 
                    class="btn btn-success">
                    Mulai Kerjakan
                </a>
            </div>
        </div>
    </div>
@endsection