@extends('front.main')

@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            @include('front.ujian._top')

            <div class="row row-deck mt-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">

                            <div class="row g-2 align-items-center">
                                <div class="col-auto">
                                    <span class="avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="7" r="4" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                                    </span>
                                </div>
                                <div class="col">
                                  <h3 class="mb-0"><a href="#">{{ $user->name }}</a></h3>
                                  <div class="text-muted text-h5">{{ $user->username }}</div>
                                </div>
                              </div>

                            <div class="row align-items-center mt-4">
                                <div class="col">
                                    <div>
                                        <div class="d-flex mb-1 align-items-center lh-1">
                                            <div class="font-weight-bolder m-0">Waktu Mengerjakan: {{ $record->getWaktuMulaiString() }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col ml-auto">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mb-0">Nilai Peserta</h3>
                            <h2 class="h1 mb-3">
                                {{ ($examable->buka_hasil == 1) ? $record->score : 'Belum dinilai' }}
                            </h2>
                            <h4>Nilai total ujian: {{ $exam->total_score }}</h4>
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
        
                        <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
                            
                            @foreach ($soal->answers as $answer)
                                <label class="form-selectgroup-item flex-fill">
                                    <input type="{{ $soal->input_type }}" 
                                        value="{{ $answer->id }}" 
                                        class="form-selectgroup-input"
                                        @if (in_array($answer->id, $userAnswers[$soal->id]))
                                            checked
                                        @endif
                                        disabled> 
            
                                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                                        <div class="mr-3">
                                            <span class="form-selectgroup-check"></span>
                                        </div>
                                        <div>
                                            {!! $answer->redaksi !!}
                                        </div>
                                        @if ($examable->buka_hasil == 1)
                                            <div class="ml-auto">
                                                Nilai: {{ $answer->nilai }}
                                            </div>
                                        @endif
                                    </div>
                                </label>
                            @endforeach

                        </div>
        
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection