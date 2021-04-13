@extends('front.kelas.base')

@section('content')
<div class="page-header">
    <h2>Tugas dan Ujian</h2>
</div>

<div class="row">

    @foreach ($exams as $exam)

        {{-- <div class="col-md-4">
            <div class="card card-link" href="#">

                <div class="card-body">
                    <h3 class="card-title">{{ $exam['judul'] }}</h3>

                    <p>{!! $exam->deskripsi !!}</p>
                </div>
                <div class="card-text">
                    <a href="{{ route('kelas.exam.info', ['kelas' => $kelas->kode, 'exam' => $exam->slug]) }}" class="btn btn-primary">Buka</a>
                </div>
            </div>
        </div> --}}
    
        <div class="col-lg-4 col-md-6 my-3">
            <div class="card">
                <div class="card-status-top bg-primary"></div>
                <div class="card-body">
                    <div class="h1 mb-3">
                        <a href="{{ route('kelas.exam.info', ['kelas' => $kelas->kode, 'exam' => $exam['slug']]) }}">
                            {{ $exam['judul'] }}
                        </a>
                    </div>
                    <div class="d-flex small">
                        <div class="d-inline-flex flex-column align-items-center mr-2">
                            <div>
                                @switch($exam['status'])
                                    @case('Belum mengerjakan')
                                    @case('Tidak selesai')
                                        <span class="text-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" /></svg>
                                        </span>                                                        
                                        @break
                                    @case('Sedang mengerjakan')
                                        <span class="text-azure">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg>
                                        </span>
                                        @break
                                    @case('Sudah mengerjakan')
                                        <span class="text-green">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><rect x="9" y="3" width="6" height="4" rx="2" /><path d="M9 14l2 2l4 -4" /></svg>
                                        </span>
                                    @break
                                        
                                @endswitch
    
                                <span>{{ $exam['status'] }}</span>
                            </div>
                        </div>
                        <div class="d-inline-flex align-items-center">
                            <div>
                                    @if ($exam['buka'] == 1)
                                        <span class="text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="5" y="11" width="14" height="10" rx="2" /><circle cx="12" cy="16" r="1" /><path d="M8 11v-5a4 4 0 0 1 8 0" /></svg>
                                        </span>                                                
                                    @else
                                        <span class="text-warning">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="5" y="11" width="14" height="10" rx="2" /><circle cx="12" cy="16" r="1" /><path d="M8 11v-4a4 4 0 0 1 8 0v4" /></svg>
                                        </span>
                                    @endif
                                <span>{{ $exam['buka'] == 1 ? 'Terbuka' : 'Ditutup'}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-text btn-list mt-3">
                        <a href="{{ route('kelas.exam.info', ['kelas' => $kelas->kode, 'exam' => $exam['slug']]) }}" class="btn btn-primary">Buka</a>
                        <a href="#" class="btn btn-primary">Lihat Hasil</a>
                    </div>
                </div>
                    
            </div>
        </div>

    @endforeach

</div>
@endsection