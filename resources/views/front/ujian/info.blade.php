@extends('front.main')

@section('content')
    <div class="row d-flex justify-content-center">

        <div class="col-md-8">

            @include('front.ujian._top')

            <div class="card mt-2">
                <div class="card-header">
                    <h2 class="card-title font-weight-bolder">Informasi Ujian</h2>
                </div>

                <div class="card-body">

                    <dl class="row">
                        <dt class="col-5">Jumlah soal:</dt>
                        <dd class="col-7">{{ $exam->questions_count }}</dd>
                        <dt class="col-5">Durasi:</dt>
                        <dd class="col-7">{{ $examable->getDurasiString() }}</dd>
                        <dt class="col-5">Batas akses:</dt>
                        <dd class="col-7">{{ $examable->getBatasBukaString() }}</dd>
                        <dt class="col-5">Status:</dt>
                        <dd class="col-7">
                            <span>
                                {{ auth()->user()->examStatus($examable->id) }}
                            </span>
                        </dd>
                        <dt class="col-5">Kesempatan mengerjakan:</dt>
                        <dd class="col-7">{{ ($examable->attempt == 0) ? 'Tidak terbatas' :  $examable->attemptRemaining(auth()->user()->id) . ' dari ' . $examable->attempt . ' kali' }}</dd>
                    </dl>

                </div>

            </div>

            @if ($userAllowed)
                <div class="alert alert-info pb-0 mt-2">
                    <ol>
                        <li>Awali segala hal baik dengan basmalah dan niat yang benar</li>
                        <li>Jelilah ketika membaca soal</li>
                    </ol>
                </div>
            @else     
                <div class="alert alert-danger pb-0 mt-2 text-center">
                    <p>Anda tidak dapat mengakses ujian ini.</p>
                </div>           
            @endif

            <div class="text-center">
                <a href="{{ route('kelas.works', ['kelas' => $kelas->kode]) }}" class="btn btn-white">Kembali</a>

                {{-- @if (auth()->user()->hasDoneExam($examable->id))
                    <a href="#" 
                        class="btn btn-primary">
                        Lihat Hasil
                    </a>                    
                @endif --}}

                @if ($userAllowed)
                    <a href="{{ route('kelas.exam.kerjakan', [ 
                                        'kelas' => $kelas->kode, 
                                        'exam' => $exam->slug 
                                    ]) }}" 
                        class="btn btn-success">
                        Mulai Kerjakan
                    </a>
                @endif

                @if (auth()->user()->examStatus($examable->id) == 'Sudah mengerjakan')
                <a href="{{ route('kelas.exam.riwayat-user', ['kelas' => $kelas->kode, 'exam' => $exam->slug]) }}" 
                    class="btn btn-azure">
                    Lihat Hasil
                </a>
                @endif

            </div>
        </div>
    </div>
@endsection