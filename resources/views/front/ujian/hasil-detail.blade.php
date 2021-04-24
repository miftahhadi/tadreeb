@extends('front.main')

@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            @include('front.ujian._top')

            <div class="text-center mt-4">
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <h2>Lembar Jawaban</h2>
                    </div>

                    <div class="row align-items-center">
                        <div class="col">
                            <dl class="row">
                                <dt class="col-5"><strong>Nama:</strong></dt>
                                <dd class="col-7">{{ $user->name }}</dd>
                                <dt class="col-5">Username:</dt>
                                <dd class="col-7">{{ $user->username }}</dd>
                                <dt class="col-5">Waktu mengerjakan:</dt>
                                <dd class="col-7">{{ $record->getWaktuMulaiString() }}</dd>
                                <dt class="col-5">Waktu selesai:</dt>
                                <dd class="col-7">{{ $record->getWaktuSelesaiString() }}</dd>
                                <dt class="col-5">Lama mengerjakan:</dt>
                                <dd class="col-7">{{ $durasi }}</dd>
                                <dt class="col-5">Mengerjakan ke:</dt>
                                <dd class="col-7">{{ $record->attempt }} kali</dd>
                            </dl>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-status-top bg-green"></div>
                                <div class="card-body text-center">
                                    <h3 class="mb-0">Nilai Peserta</h3>
                                    @if ($examable->buka_hasil == 1)
                                        <span class="h1">{{ $record->score }}</span><span>/{{ $exam->total_score }}</span>
                                    @else
                                    <h2 class="h1">
                                        Belum dinilai
                                    </h2>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
    
            @foreach ($exam->questions as $key => $soal)
                <div class="card mt-4">
                    <div class="card-header">
                        Soal ke-{{ ++$key }} dari {{ $exam->questions_count }} 
        
                    </div>
                    <div class="card-body">
                        {!! $soal->konten !!}

                        @foreach ($soal->answers as $answer)                            
                            @if ($examable->buka_hasil == 1)

                                <div class="card card-sm mb-1 
                                                @if ($answer->userAnswerCorrect($userAnswers[$soal->id])) 
                                                    bg-green-lt 
                                                @elseif (in_array($answer->id, $userAnswers[$soal->id]))
                                                    bg-red-lt
                                                @endif">
                                    @if (in_array($answer->id, $userAnswers[$soal->id])) 
                                        <div class="card-header p-2">
                                            <div class="d-flex">
                                                <div>
                                                    @if ($answer->userAnswerCorrect($userAnswers[$soal->id]))
                                                        <span class="text-success">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                                        </span>
                                                    @elseif (in_array($answer->id, $userAnswers[$soal->id]))
                                                        <span class="text-danger">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>
                                                        </span>
                                                    @else 
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 4.5l-4 4l-4 1.5l-1.5 1.5l7 7l1.5 -1.5l1.5 -4l4 -4" /><line x1="9" y1="15" x2="4.5" y2="19.5" /><line x1="14.5" y1="4" x2="20" y2="9.5" /></svg>
                                                    @endif
                                                </div>
                                                <div>
                                                    Jawaban {{ request('user') ? 'Peserta' : 'Anda'}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        {!! $answer->redaksi !!}

                                        <div>
                                            <strong>Nilai: {{ $answer->nilai }}</strong>
                                        </div>
                                    </div>
                                </div>

                            @else
                                <div class="card card-sm mb-1
                                                @if (in_array($answer->id, $userAnswers[$soal->id]))
                                                    bg-blue-lt
                                                @endif">
                                    @if (in_array($answer->id, $userAnswers[$soal->id]))
                                        <div class="card-header p-2">
                                            Jawaban {{ request('user') ? 'Peserta' : 'Anda'}}
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        {!! $answer->redaksi !!}
                                    </div>
                                </div>
                            @endif
                        @endforeach
        
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection